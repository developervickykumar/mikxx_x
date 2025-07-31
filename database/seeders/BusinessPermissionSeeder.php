<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessPermission;
use Illuminate\Database\Seeder;

class BusinessPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            [
                'name' => 'View Dashboard',
                'slug' => 'view_dashboard',
                'module' => 'Dashboard',
                'page' => 'dashboard',
                'description' => 'Can view the business dashboard'
            ],

            // Profile Management
            [
                'name' => 'View Profile',
                'slug' => 'view_profile',
                'module' => 'Profile',
                'page' => 'profile',
                'description' => 'Can view business profile'
            ],
            [
                'name' => 'Edit Profile',
                'slug' => 'edit_profile',
                'module' => 'Profile',
                'page' => 'profile',
                'description' => 'Can edit business profile'
            ],

            // Team Management
            [
                'name' => 'View Team',
                'slug' => 'view_team',
                'module' => 'Team',
                'page' => 'team',
                'description' => 'Can view team members'
            ],
            [
                'name' => 'Manage Team',
                'slug' => 'manage_team',
                'module' => 'Team',
                'page' => 'team',
                'description' => 'Can add, edit, and remove team members'
            ],

            // Role Management
            [
                'name' => 'View Roles',
                'slug' => 'view_roles',
                'module' => 'Roles',
                'page' => 'roles',
                'description' => 'Can view business roles'
            ],
            [
                'name' => 'Manage Roles',
                'slug' => 'manage_roles',
                'module' => 'Roles',
                'page' => 'roles',
                'description' => 'Can create, edit, and delete roles'
            ],

            // Reports
            [
                'name' => 'View Reports',
                'slug' => 'view_reports',
                'module' => 'Reports',
                'page' => 'reports',
                'description' => 'Can view business reports'
            ],
            [
                'name' => 'Generate Reports',
                'slug' => 'generate_reports',
                'module' => 'Reports',
                'page' => 'reports',
                'description' => 'Can generate and export reports'
            ],

            // Settings
            [
                'name' => 'View Settings',
                'slug' => 'view_settings',
                'module' => 'Settings',
                'page' => 'settings',
                'description' => 'Can view business settings'
            ],
            [
                'name' => 'Manage Settings',
                'slug' => 'manage_settings',
                'module' => 'Settings',
                'page' => 'settings',
                'description' => 'Can modify business settings'
            ],
        ];

        // Create permissions for each business
        Business::all()->each(function ($business) use ($permissions) {
            foreach ($permissions as $permission) {
                $business->permissions()->create($permission);
            }
        });
    }
} 