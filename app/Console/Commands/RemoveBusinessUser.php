<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\User;
use Illuminate\Console\Command;

class RemoveBusinessUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:remove-user 
                            {business : The business slug}
                            {email : The user email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a user from a business';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $email = $this->argument('email');

        $business = Business::where('slug', $businessSlug)->first();
        if (!$business) {
            $this->error('Business not found.');
            return 1;
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error('User not found.');
            return 1;
        }

        if (!$user->businesses->contains($business)) {
            $this->error("User is not associated with this business.");
            return 1;
        }

        if ($this->confirm("Are you sure you want to remove user '{$user->name}' from business '{$business->name}'?")) {
            // Remove user's roles for this business
            $user->businessRoles()
                ->wherePivot('business_id', $business->id)
                ->detach();

            // Remove user from business
            $user->businesses()->detach($business->id);

            $this->info("User '{$user->name}' removed from business '{$business->name}'.");
        }

        return 0;
    }
} 