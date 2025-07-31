<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddBusinessUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:add-user 
                            {business : The business slug}
                            {name : The user name}
                            {email : The user email}
                            {--password= : The user password (random if not provided)}
                            {--role= : The role slug to assign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user to a business';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $businessSlug = $this->argument('business');
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->option('password') ?? Str::random(12);
        $roleSlug = $this->option('role');

        $business = Business::where('slug', $businessSlug)->first();
        if (!$business) {
            $this->error('Business not found.');
            return 1;
        }

        // Check if user already exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            // Create new user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $this->info("User '{$user->name}' created successfully.");
        } else {
            $this->info("User '{$user->name}' already exists.");
        }

        // Check if user is already associated with the business
        if ($user->businesses->contains($business)) {
            $this->warn("User is already associated with this business.");
        } else {
            // Associate user with business
            $user->businesses()->attach($business->id);
            $this->info("User associated with business '{$business->name}'.");
        }

        // Assign role if specified
        if ($roleSlug) {
            $role = $business->roles()->where('slug', $roleSlug)->first();
            if (!$role) {
                $this->error("Role '{$roleSlug}' not found.");
                return 1;
            }

            // Remove any existing roles for this business
            $user->businessRoles()
                ->wherePivot('business_id', $business->id)
                ->detach();

            // Assign the new role
            $user->businessRoles()->attach($role->id);
            $this->info("Role '{$role->name}' assigned to user.");
        }

        if (!$user->wasRecentlyCreated) {
            $this->info("\nUser credentials:");
            $this->info("Email: {$user->email}");
            $this->info("Password: {$password}");
        }

        return 0;
    }
} 