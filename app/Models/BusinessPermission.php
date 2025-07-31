<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusinessPermission extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'slug',
        'action',
        'resource_type',
        'resource_id',
        'conditions',
        'description',
        'module',
        'page',
        'is_system',
        'priority'
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_system' => 'boolean'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(BusinessRole::class, 'business_role_permission')
            ->withTimestamps();
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(BusinessPermissionGroup::class, 'business_permission_group_permission')
            ->withTimestamps();
    }

    public function checkConditions(array $context = []): bool
    {
        if (empty($this->conditions)) {
            return true;
        }

        foreach ($this->conditions as $condition) {
            if (!$this->evaluateCondition($condition, $context)) {
                return false;
            }
        }

        return true;
    }

    protected function evaluateCondition(array $condition, array $context): bool
    {
        $operator = $condition['operator'] ?? '=';
        $value = $condition['value'] ?? null;
        $contextValue = $context[$condition['field']] ?? null;

        return match ($operator) {
            '=' => $contextValue === $value,
            '!=' => $contextValue !== $value,
            '>' => $contextValue > $value,
            '>=' => $contextValue >= $value,
            '<' => $contextValue < $value,
            '<=' => $contextValue <= $value,
            'in' => in_array($contextValue, (array)$value),
            'not_in' => !in_array($contextValue, (array)$value),
            'contains' => str_contains($contextValue, $value),
            'starts_with' => str_starts_with($contextValue, $value),
            'ends_with' => str_ends_with($contextValue, $value),
            default => false,
        };
    }

    public static function getDefaultPermissions(): array
    {
        return [
            // User Management
            [
                'name' => 'View Users',
                'slug' => 'view-users',
                'action' => 'view',
                'resource_type' => 'users',
                'module' => 'User Management',
                'page' => 'users.index',
                'is_system' => true,
                'priority' => 1
            ],
            [
                'name' => 'Create Users',
                'slug' => 'create-users',
                'action' => 'create',
                'resource_type' => 'users',
                'module' => 'User Management',
                'page' => 'users.create',
                'is_system' => true,
                'priority' => 2
            ],
            [
                'name' => 'Edit Users',
                'slug' => 'edit-users',
                'action' => 'update',
                'resource_type' => 'users',
                'module' => 'User Management',
                'page' => 'users.edit',
                'is_system' => true,
                'priority' => 3
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'delete-users',
                'action' => 'delete',
                'resource_type' => 'users',
                'module' => 'User Management',
                'page' => 'users.destroy',
                'is_system' => true,
                'priority' => 4
            ],

            // Role Management
            [
                'name' => 'View Roles',
                'slug' => 'view-roles',
                'action' => 'view',
                'resource_type' => 'roles',
                'module' => 'User Management',
                'page' => 'roles.index',
                'is_system' => true,
                'priority' => 5
            ],
            [
                'name' => 'Create Roles',
                'slug' => 'create-roles',
                'action' => 'create',
                'resource_type' => 'roles',
                'module' => 'User Management',
                'page' => 'roles.create',
                'is_system' => true,
                'priority' => 6
            ],
            [
                'name' => 'Edit Roles',
                'slug' => 'edit-roles',
                'action' => 'update',
                'resource_type' => 'roles',
                'module' => 'User Management',
                'page' => 'roles.edit',
                'is_system' => true,
                'priority' => 7
            ],
            [
                'name' => 'Delete Roles',
                'slug' => 'delete-roles',
                'action' => 'delete',
                'resource_type' => 'roles',
                'module' => 'User Management',
                'page' => 'roles.destroy',
                'is_system' => true,
                'priority' => 8
            ],

            // Content Management
            [
                'name' => 'View Content',
                'slug' => 'view-content',
                'action' => 'view',
                'resource_type' => 'content',
                'module' => 'Content Management',
                'page' => 'content.index',
                'is_system' => true,
                'priority' => 9
            ],
            [
                'name' => 'Create Content',
                'slug' => 'create-content',
                'action' => 'create',
                'resource_type' => 'content',
                'module' => 'Content Management',
                'page' => 'content.create',
                'is_system' => true,
                'priority' => 10
            ],
            [
                'name' => 'Edit Content',
                'slug' => 'edit-content',
                'action' => 'update',
                'resource_type' => 'content',
                'module' => 'Content Management',
                'page' => 'content.edit',
                'is_system' => true,
                'priority' => 11
            ],
            [
                'name' => 'Delete Content',
                'slug' => 'delete-content',
                'action' => 'delete',
                'resource_type' => 'content',
                'module' => 'Content Management',
                'page' => 'content.destroy',
                'is_system' => true,
                'priority' => 12
            ],

            // Settings
            [
                'name' => 'View Settings',
                'slug' => 'view-settings',
                'action' => 'view',
                'resource_type' => 'settings',
                'module' => 'Settings',
                'page' => 'settings.index',
                'is_system' => true,
                'priority' => 13
            ],
            [
                'name' => 'Edit Settings',
                'slug' => 'edit-settings',
                'action' => 'update',
                'resource_type' => 'settings',
                'module' => 'Settings',
                'page' => 'settings.edit',
                'is_system' => true,
                'priority' => 14
            ],

            // Reports
            [
                'name' => 'View Reports',
                'slug' => 'view-reports',
                'action' => 'view',
                'resource_type' => 'reports',
                'module' => 'Reports',
                'page' => 'reports.index',
                'is_system' => true,
                'priority' => 15
            ],
            [
                'name' => 'Generate Reports',
                'slug' => 'generate-reports',
                'action' => 'create',
                'resource_type' => 'reports',
                'module' => 'Reports',
                'page' => 'reports.generate',
                'is_system' => true,
                'priority' => 16
            ],
            [
                'name' => 'Export Reports',
                'slug' => 'export-reports',
                'action' => 'export',
                'resource_type' => 'reports',
                'module' => 'Reports',
                'page' => 'reports.export',
                'is_system' => true,
                'priority' => 17
            ]
        ];
    }
} 