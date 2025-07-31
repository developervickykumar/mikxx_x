<?php

namespace App\Services;

use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\BusinessPermission;
use App\Models\BusinessPermissionGroup;

class BusinessPermissionService
{
    public function createDefaultPermissions(Business $business)
    {
        // Create default permission groups
        $groups = [
            'User Management' => 'Manage users and their roles',
            'Content Management' => 'Manage business content',
            'Settings' => 'Manage business settings',
            'Reports' => 'View and manage reports'
        ];

        foreach ($groups as $name => $description) {
            BusinessPermissionGroup::create([
                'business_id' => $business->id,
                'name' => $name,
                'slug' => \Str::slug($name),
                'description' => $description
            ]);
        }

        // Create default permissions
        $permissions = [
            'User Management' => [
                'view_users' => 'View users',
                'create_users' => 'Create users',
                'edit_users' => 'Edit users',
                'delete_users' => 'Delete users',
                'assign_roles' => 'Assign roles to users'
            ],
            'Content Management' => [
                'view_content' => 'View content',
                'create_content' => 'Create content',
                'edit_content' => 'Edit content',
                'delete_content' => 'Delete content'
            ],
            'Settings' => [
                'view_settings' => 'View settings',
                'edit_settings' => 'Edit settings'
            ],
            'Reports' => [
                'view_reports' => 'View reports',
                'export_reports' => 'Export reports'
            ]
        ];

        foreach ($permissions as $group => $groupPermissions) {
            $permissionGroup = BusinessPermissionGroup::where('business_id', $business->id)
                ->where('name', $group)
                ->first();

            foreach ($groupPermissions as $slug => $description) {
                BusinessPermission::create([
                    'business_id' => $business->id,
                    'name' => $description,
                    'slug' => $slug,
                    'description' => $description,
                    'group_id' => $permissionGroup->id
                ]);
            }
        }

        // Create default roles
        $roles = [
            'Administrator' => 'Full access to all features',
            'Manager' => 'Can manage content and users',
            'Editor' => 'Can create and edit content',
            'Viewer' => 'Can only view content'
        ];

        foreach ($roles as $name => $description) {
            BusinessRole::create([
                'business_id' => $business->id,
                'name' => $name,
                'slug' => \Str::slug($name),
                'description' => $description
            ]);
        }

        // Assign all permissions to Administrator role
        $adminRole = BusinessRole::where('business_id', $business->id)
            ->where('name', 'Administrator')
            ->first();

        $allPermissions = BusinessPermission::where('business_id', $business->id)->get();
        $adminRole->permissions()->attach($allPermissions->pluck('id'));
    }
} 