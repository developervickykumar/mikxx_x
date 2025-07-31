<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusinessPermissionGroup extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'slug',
        'description',
        'is_system'
    ];

    protected $casts = [
        'is_system' => 'boolean'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(BusinessPermission::class, 'business_permission_group_permission')
            ->withTimestamps();
    }

    public static function getDefaultGroups(): array
    {
        return [
            [
                'name' => 'User Management',
                'slug' => 'user-management',
                'description' => 'Permissions for managing users and their roles',
                'is_system' => true
            ],
            [
                'name' => 'Content Management',
                'slug' => 'content-management',
                'description' => 'Permissions for managing content and resources',
                'is_system' => true
            ],
            [
                'name' => 'Settings',
                'slug' => 'settings',
                'description' => 'Permissions for managing system settings',
                'is_system' => true
            ],
            [
                'name' => 'Reports',
                'slug' => 'reports',
                'description' => 'Permissions for accessing and managing reports',
                'is_system' => true
            ]
        ];
    }
} 