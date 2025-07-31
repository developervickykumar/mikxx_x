<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\User;
use Illuminate\Console\Command;

class AssignBusinessRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:assign-role {business} {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a business role to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $email = $this->argument('email');
        $roleSlug = $this->argument('role');

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
            $this->error('User is not associated with this business.');
            return 1;
        }

        $role = $business->roles()->where('slug', $roleSlug)->first();
        if (!$role) {
            $this->error('Role not found.');
            return 1;
        }

        // Remove any existing roles for this business
        $user->businessRoles()
            ->wherePivot('business_id', $business->id)
            ->detach();

        // Assign the new role
        $user->businessRoles()->attach($role->id);

        $this->info("Role '{$role->name}' assigned to user '{$user->name}' for business '{$business->name}'.");
        return 0;
    }
} 