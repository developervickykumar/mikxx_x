<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class ListBusinesses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all businesses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businesses = Business::withCount(['users', 'roles', 'permissions'])->get();

        if ($businesses->isEmpty()) {
            $this->info('No businesses found.');
            return 0;
        }

        $this->info("\nBusinesses:");
        foreach ($businesses as $business) {
            $this->info("\nBusiness: {$business->name}");
            $this->info("Slug: {$business->slug}");
            $this->info("Description: {$business->description}");
            $this->info("Users: {$business->users_count}");
            $this->info("Roles: {$business->roles_count}");
            $this->info("Permissions: {$business->permissions_count}");
        }

        return 0;
    }
} 