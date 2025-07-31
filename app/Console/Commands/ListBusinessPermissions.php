<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class ListBusinessPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:list-permissions {business?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all business permissions';

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
            $this->listPermissionsForBusiness($business);
        } else {
            $businesses = Business::all();
            foreach ($businesses as $business) {
                $this->info("\nBusiness: {$business->name}");
                $this->listPermissionsForBusiness($business);
            }
        }

        return 0;
    }

    /**
     * List permissions for a specific business.
     */
    protected function listPermissionsForBusiness(Business $business)
    {
        $permissions = $business->permissions()->get()->groupBy('module');

        foreach ($permissions as $module => $modulePermissions) {
            $this->info("\n{$module}:");
            foreach ($modulePermissions as $permission) {
                $this->info("  - {$permission->name}");
                $this->info("    Slug: {$permission->slug}");
                $this->info("    Page: {$permission->page}");
                $this->info("    Description: {$permission->description}");
            }
        }
    }
} 