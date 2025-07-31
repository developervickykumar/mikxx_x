<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class DeleteBusiness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:delete {business : The business slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a business';

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

        $userCount = $business->users()->count();
        $roleCount = $business->roles()->count();
        $permissionCount = $business->permissions()->count();

        $this->warn("\nThis will delete the business '{$business->name}' and all associated data:");
        $this->warn("- {$userCount} users will be unlinked from this business");
        $this->warn("- {$roleCount} roles will be deleted");
        $this->warn("- {$permissionCount} permissions will be deleted");

        if ($this->confirm('Are you sure you want to delete this business?')) {
            $business->delete();
            $this->info("Business '{$business->name}' deleted successfully.");
        }

        return 0;
    }
} 