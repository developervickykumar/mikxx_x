<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Traits\HasTableValidation;

class TableBuilder extends Model
{
    use HasFactory, HasTableValidation;

    protected $fillable = [
        'name',
        'description',
        'columns',
        'user_id',
        'is_template',
        'category',
        'tags',
        'version',
        'parent_id',
        'validation_rules',
        'column_dependencies',
        'column_comments',
        'column_order',
        'is_shared',
        'shared_with',
        'permissions',
        'last_backup_at',
        'backup_path'
    ];

    protected $casts = [
        'columns' => 'array',
        'tags' => 'array',
        'validation_rules' => 'array',
        'column_dependencies' => 'array',
        'column_comments' => 'array',
        'column_order' => 'array',
        'shared_with' => 'array',
        'permissions' => 'array',
        'is_template' => 'boolean',
        'is_shared' => 'boolean',
        'last_backup_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::created(function ($table) {
            $table->logActivity('created');
        });

        static::updated(function ($table) {
            $table->logActivity('updated');
        });

        static::deleted(function ($table) {
            $table->logActivity('deleted');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(TableBuilder::class, 'parent_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(TableBuilder::class, 'parent_id');
    }

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function graphs(): HasMany
    {
        return $this->hasMany(Graph::class);
    }

    public function createBackup(): bool
    {
        try {
            $backupData = [
                'table' => $this->toArray(),
                'forms' => $this->forms->toArray(),
                'graphs' => $this->graphs->toArray(),
                'timestamp' => now()
            ];

            $filename = "backup_{$this->id}_" . now()->format('Y-m-d_His') . '.json';
            $path = "table-backups/{$filename}";

            Storage::put($path, json_encode($backupData, JSON_PRETTY_PRINT));

            $this->update([
                'last_backup_at' => now(),
                'backup_path' => $path
            ]);

            return true;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function restoreFromBackup(string $backupPath): bool
    {
        try {
            if (!Storage::exists($backupPath)) {
                return false;
            }

            $backupData = json_decode(Storage::get($backupPath), true);

            DB::beginTransaction();

            // Restore table data
            $this->update($backupData['table']);

            // Restore forms
            if (isset($backupData['forms'])) {
                foreach ($backupData['forms'] as $formData) {
                    $this->forms()->updateOrCreate(
                        ['id' => $formData['id']],
                        $formData
                    );
                }
            }

            // Restore graphs
            if (isset($backupData['graphs'])) {
                foreach ($backupData['graphs'] as $graphData) {
                    $this->graphs()->updateOrCreate(
                        ['id' => $graphData['id']],
                        $graphData
                    );
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return false;
        }
    }

    public function incrementVersion(): void
    {
        $this->version++;
        $this->save();
    }

    public function shareWith(array $userIds, array $permissions = ['view']): void
    {
        $this->update([
            'is_shared' => true,
            'shared_with' => $userIds,
            'permissions' => $permissions
        ]);
    }

    public function unshare(): void
    {
        $this->update([
            'is_shared' => false,
            'shared_with' => null,
            'permissions' => null
        ]);
    }

    public function hasPermission(User $user, string $permission): bool
    {
        if ($this->user_id === $user->id) {
            return true;
        }

        if (!$this->is_shared) {
            return false;
        }

        return in_array($user->id, $this->shared_with ?? []) &&
            in_array($permission, $this->permissions ?? []);
    }

    public function reorderColumns(array $newOrder): void
    {
        $this->column_order = $newOrder;
        $this->save();
    }

    public function addColumnComment(string $columnName, string $comment): void
    {
        $comments = $this->column_comments ?? [];
        $comments[$columnName] = $comment;
        $this->column_comments = $comments;
        $this->save();
    }

    public function addColumnDependency(string $columnName, array $dependencies): void
    {
        $deps = $this->column_dependencies ?? [];
        $deps[$columnName] = $dependencies;
        $this->column_dependencies = $deps;
        $this->save();
    }

    public function addValidationRule(string $columnName, array $rules): void
    {
        $validationRules = $this->validation_rules ?? [];
        $validationRules[$columnName] = $rules;
        $this->validation_rules = $validationRules;
        $this->save();
    }

    public function logActivity(string $action, array $details = []): void
    {
        activity()
            ->performedOn($this)
            ->causedBy(auth()->user())
            ->withProperties([
                'action' => $action,
                'details' => $details,
                'table_name' => $this->name,
                'changes' => $this->getDirty()
            ])
            ->log("Table {$action}");
    }

    public function getActivityLog(): \Illuminate\Database\Eloquent\Collection
    {
        return activity()
            ->performedOn($this)
            ->with(['causer'])
            ->latest()
            ->get();
    }

    public function getColumnPermissions(User $user): array
    {
        if ($this->user_id === $user->id) {
            return array_fill_keys(array_column($this->columns, 'name'), ['view', 'edit', 'delete']);
        }

        if (!$this->is_shared || !in_array($user->id, $this->shared_with ?? [])) {
            return [];
        }

        $permissions = [];
        foreach ($this->columns as $column) {
            $columnPermissions = $this->permissions['columns'][$column['name']] ?? ['view'];
            if (in_array($user->id, $columnPermissions['users'] ?? [])) {
                $permissions[$column['name']] = $columnPermissions['actions'] ?? ['view'];
            }
        }

        return $permissions;
    }

    public function hasColumnPermission(User $user, string $column, string $permission): bool
    {
        $columnPermissions = $this->getColumnPermissions($user);
        return in_array($permission, $columnPermissions[$column] ?? []);
    }

    public function updateColumnPermissions(string $column, array $permissions): void
    {
        $currentPermissions = $this->permissions ?? [];
        $currentPermissions['columns'][$column] = $permissions;
        $this->permissions = $currentPermissions;
        $this->save();
    }
}
