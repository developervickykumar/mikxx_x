<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessRole;
use Illuminate\Console\Command;

class DeleteBusinessRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:delete-role 
                            {business : The business slug}
                            {role : The role slug}
                            {--force : Force delete even if it is a default role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a business role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $roleSlug = $this->argument('role');
        $force = $this->option('force');

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

        if ($role->is_default && !$force) {
            $this->error('Cannot delete default role. Use --force to override.');
            return 1;
        }

        if ($this->confirm("Are you sure you want to delete the role '{$role->name}'?")) {
            $role->delete();
            $this->info("Role '{$role->name}' deleted successfully.");
        }

        return 0;
    }
} 