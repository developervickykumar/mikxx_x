<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\BusinessPermissionService;

class Business extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    protected static function booted()
    {
        static::created(function ($business) {
            app(BusinessPermissionService::class)->createDefaultPermissions($business);
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(BusinessRole::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(BusinessPermission::class);
    }

    public function permissionGroups(): HasMany
    {
        return $this->hasMany(BusinessPermissionGroup::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(BusinessPermissionAuditLog::class);
    }

    public function getAuditLogs(array $filters = [], int $limit = 50): LengthAwarePaginator
    {
        $query = $this->auditLogs()->with('user');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['start_date'])) {
            $query->where('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('created_at', '<=', $filters['end_date']);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    public function createDefaultRoles(): void
    {
        $adminRole = $this->roles()->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'Full access to all features and settings',
            'is_default' => true
        ]);

        $userRole = $this->roles()->create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Basic access to assigned features',
            'is_default' => true
        ]);

        // Create default permissions
        $permissions = BusinessPermission::getDefaultPermissions();
        foreach ($permissions as $permissionData) {
            $permission = $this->permissions()->create($permissionData);
            
            // Assign all permissions to admin role
            $adminRole->permissions()->attach($permission->id);
            
            // Assign basic permissions to user role
            if (in_array($permission->action, ['view']) && 
                in_array($permission->resource_type, ['content', 'reports'])) {
                $userRole->permissions()->attach($permission->id);
            }
        }

        // Create default permission groups
        $groups = BusinessPermissionGroup::getDefaultGroups();
        foreach ($groups as $groupData) {
            $group = $this->permissionGroups()->create($groupData);
            
            // Assign relevant permissions to each group
            $groupPermissions = $this->permissions()
                ->where('module', $group->name)
                ->pluck('id')
                ->toArray();
            
            $group->permissions()->attach($groupPermissions);
        }
    }

    public function clearPermissionCache(): void
    {
        $this->users->each->clearPermissionCache();
    }
} 