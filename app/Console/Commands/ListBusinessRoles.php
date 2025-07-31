<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class ListBusinessRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:list-roles {business?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all business roles and their permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');

        if ($businessSlug) {
            $business = Business::where('slug', $businessSlug)->first();
            if (!$business) {
                $this->error('Business not found.');
                return 1;
            }
            $this->listRolesForBusiness($business);
        } else {
            $businesses = Business::all();
            foreach ($businesses as $business) {
                $this->info("\nBusiness: {$business->name}");
                $this->listRolesForBusiness($business);
            }
        }

        return 0;
    }

    /**
     * List roles and permissions for a specific business.
     */
    protected function listRolesForBusiness(Business $business)
    {
        $roles = $business->roles()->with('permissions')->get();

        foreach ($roles as $role) {
            $this->info("\nRole: {$role->name}");
            $this->info("Description: {$role->description}");
            $this->info("Default: " . ($role->is_default ? 'Yes' : 'No'));
            $this->info("Permissions:");

            $permissions = $role->permissions->groupBy('module');
            foreach ($permissions as $module => $modulePermissions) {
                $this->info("\n  {$module}:");
                foreach ($modulePermissions as $permission) {
                    $this->info("    - {$permission->name} ({$permission->slug})");
                }
            }
        }
    }
} 