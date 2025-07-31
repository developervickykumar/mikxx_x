<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessPermission;
use Illuminate\Console\Command;

class DeleteBusinessPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:delete-permission 
                            {business : The business slug}
                            {permission : The permission slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a business permission';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $permissionSlug = $this->argument('permission');

        $business = Business::where('slug', $businessSlug)->first();
        if (!$business) {
            $this->error('Business not found.');
            return 1;
        }

        $permission = $business->permissions()->where('slug', $permissionSlug)->first();
        if (!$permission) {
            $this->error('Permission not found.');
            return 1;
        }

        // Check if permission is used by any roles
        $roleCount = $permission->roles()->count();
        if ($roleCount > 0) {
            $this->warn("This permission is used by {$roleCount} roles.");
            if (!$this->confirm('Are you sure you want to delete this permission?')) {
                return 0;
            }
        }

        if ($this->confirm("Are you sure you want to delete the permission '{$permission->name}'?")) {
            $permission->delete();
            $this->info("Permission '{$permission->name}' deleted successfully.");
        }

        return 0;
    }
} 