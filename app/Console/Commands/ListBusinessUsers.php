<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class ListBusinessUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:list-users {business : The business slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users with their roles for a business';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');

        $business = Business::where('slug', $businessSlug)->first();
        if (!$business) {
            $this->error('Business not found.');
            return 1;
        }

        $users = $business->users()->with('businessRoles')->get();

        if ($users->isEmpty()) {
            $this->info('No users found for this business.');
            return 0;
        }

        $this->info("\nUsers for business '{$business->name}':");
        foreach ($users as $user) {
            $this->info("\nUser: {$user->name} ({$user->email})");
            $this->info("Roles:");
            
            $roles = $user->businessRoles()
                ->where('business_id', $business->id)
                ->get();

            if ($roles->isEmpty()) {
                $this->info("  No roles assigned");
            } else {
                foreach ($roles as $role) {
                    $this->info("  - {$role->name}");
                    $this->info("    Permissions:");
                    
                    $permissions = $role->permissions->groupBy('module');
                    foreach ($permissions as $module => $modulePermissions) {
                        $this->info("      {$module}:");
                        foreach ($modulePermissions as $permission) {
                            $this->info("        - {$permission->name}");
                        }
                    }
                }
            }
        }

        return 0;
    }
} 