<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessRole;
use Illuminate\Console\Command;

class RemoveBusinessPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:remove-permissions 
                            {business : The business slug}
                            {role : The role slug}
                            {--permissions=* : The permission slugs to remove}
                            {--all : Remove all permissions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove permissions from a business role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $roleSlug = $this->argument('role');
        $permissionSlugs = $this->option('permissions');
        $removeAll = $this->option('all');

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

        if ($removeAll) {
            $role->permissions()->detach();
            $this->info("All permissions removed from role '{$role->name}'.");
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

            $role->permissions()->detach($permissions);
            $this->info("Permissions removed from role '{$role->name}':");
            foreach ($permissionSlugs as $slug) {
                $this->info("  - {$slug}");
            }
        }

        return 0;
    }
} 