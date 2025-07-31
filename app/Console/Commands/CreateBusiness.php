<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateBusiness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:create {name} {email} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new business with default roles and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password') ?? Str::random(12);

        DB::beginTransaction();

        try {
            // Create the business
            $business = Business::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Business created via command line",
            ]);

            // Create the admin user
            $user = User::create([
                'name' => $name . ' Admin',
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            // Attach the user to the business
            $user->businesses()->attach($business->id);

            // Create default permissions
            $this->call('db:seed', [
                '--class' => 'BusinessPermissionSeeder',
                '--force' => true,
            ]);

            // Create default roles
            $this->call('db:seed', [
                '--class' => 'BusinessRoleSeeder',
                '--force' => true,
            ]);

            // Assign the administrator role to the user
            $adminRole = $business->roles()->where('slug', 'administrator')->first();
            $user->businessRoles()->attach($adminRole->id);

            DB::commit();

            $this->info('Business created successfully!');
            $this->info('Business Name: ' . $name);
            $this->info('Admin Email: ' . $email);
            $this->info('Admin Password: ' . $password);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Failed to create business: ' . $e->getMessage());
        }
    }
} 