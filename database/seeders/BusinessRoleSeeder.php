<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessRole;
use Illuminate\Database\Seeder;

class BusinessRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'Full access to all business features',
                'is_default' => true,
                'permissions' => [
                    'view_dashboard',
                    'view_profile',
                    'edit_profile',
                    'view_team',
                    'manage_team',
                    'view_roles',
                    'manage_roles',
                    'view_reports',
                    'generate_reports',
                    'view_settings',
                    'manage_settings'
                ]
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Can manage team and view reports',
                'is_default' => true,
                'permissions' => [
                    'view_dashboard',
                    'view_profile',
                    'view_team',
                    'manage_team',
                    'view_roles',
                    'view_reports',
                    'generate_reports',
                    'view_settings'
                ]
            ],
            [
                'name' => 'Viewer',
                'slug' => 'viewer',
                'description' => 'Can only view basic information',
                'is_default' => true,
                'permissions' => [
                    'view_dashboard',
                    'view_profile',
                    'view_team',
                    'view_reports',
                    'view_settings'
                ]
            ]
        ];

        // Create roles for each business
        Business::all()->each(function ($business) use ($roles) {
            foreach ($roles as $roleData) {
                $permissions = $business->permissions()
                    ->whereIn('slug', $roleData['permissions'])
                    ->pluck('id');

                $role = $business->roles()->create([
                    'name' => $roleData['name'],
                    'slug' => $roleData['slug'],
                    'description' => $roleData['description'],
                    'is_default' => $roleData['is_default']
                ]);

                $role->permissions()->attach($permissions);
            }
        });
    }
} 