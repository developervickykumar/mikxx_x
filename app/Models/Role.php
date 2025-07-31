<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status',
        'is_system'
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'status' => 'boolean'
    ];

    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:roles,id',
            'status' => 'boolean',
            'is_system' => 'boolean'
        ];
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }

    public function children(): BelongsToMany
    {
        return $this->hasMany(Role::class, 'parent_id');
    }

    public function hasFeatureAccess(string $feature): bool
    {
        // Check direct permissions
        if ($this->permissions->contains('name', $feature)) {
            return true;
        }

        // Check parent role permissions
        if ($this->parent && $this->parent->hasFeatureAccess($feature)) {
            return true;
        }

        return false;
    }

    public function getAccessibleFeatures(): array
    {
        $features = $this->permissions->pluck('name')->toArray();

        // Include parent role features
        if ($this->parent) {
            $features = array_merge($features, $this->parent->getAccessibleFeatures());
        }

        return array_unique($features);
    }

    public function isActive(): bool
    {
        return $this->status === true;
    }

    public function isSystem(): bool
    {
        return $this->is_system === true;
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }
} 