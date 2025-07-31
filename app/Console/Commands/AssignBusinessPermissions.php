<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessRole;
use Illuminate\Console\Command;

class AssignBusinessPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:assign-permissions 
                            {business : The business slug}
                            {role : The role slug}
                            {--permissions=* : The permission slugs to assign}
                            {--all : Assign all permissions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign permissions to a business role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $roleSlug = $this->argument('role');
        $permissionSlugs = $this->option('permissions');
        $assignAll = $this->option('all');

        $business = Business::where('slug', $businessSlug)->first();
        if (!$business) {
            $this->error('Business not found.');
            return 1;
        }

        $role = $business->roles()->where('slug', $roleSlug)->first();
        if (!$role) {
            $this->error('Role not found.');
            return 1;
        }

        if ($assignAll) {
            $permissions = $business->permissions()->pluck('id');
            $role->permissions()->sync($permissions);
            $this->info("All permissions assigned to role '{$role->name}'.");
        } else {
            if (empty($permissionSlugs)) {
                $this->error('No permissions specified.');
                return 1;
            }

            $permissions = $business->permissions()
                ->whereIn('slug', $permissionSlugs)
                ->pluck('id');

            if ($permissions->isEmpty()) {
                $this->error('No valid permissions found.');
                return 1;
            }

            $role->permissions()->sync($permissions);
            $this->info("Permissions assigned to role '{$role->name}':");
            foreach ($permissionSlugs as $slug) {
                $this->info("  - {$slug}");
            }
        }

        return 0;
    }
} 