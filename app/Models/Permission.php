<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'module',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'status' => 'boolean'
    ];

    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name',
            'slug' => 'required|string|max:255|unique:permissions,slug',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'status' => 'boolean',
            'is_system' => 'boolean'
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === true;
    }

    public function isSystem(): bool
    {
        return $this->is_system === true;
    }

    public static function getCategories(): array
    {
        return [
            'user' => 'User Management',
            'role' => 'Role Management',
            'permission' => 'Permission Management',
            'form-builder' => 'Form Builder',
            'categories' => 'Categories',
            'builder' => 'Builder',
            'system' => 'System'
        ];
    }
} 