<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\User;
use Illuminate\Console\Command;

class ManageUserRoles extends Command
{
    protected $signature = 'business:user-roles
                            {business : The business slug}
                            {action : The action to perform (list|assign|remove)}
                            {--email= : The email of the user}
                            {--role= : The slug of the role}';

    protected $description = 'Manage user role assignments';

    public function handle(): int
    {
        $business = Business::where('slug', $this->argument('business'))->first();

        if (!$business) {
            $this->error("Business not found.");
            return 1;
        }

        $action = $this->argument('action');

        return match ($action) {
            'list' => $this->listUserRoles($business),
            'assign' => $this->assignRole($business),
            'remove' => $this->removeRole($business),
            default => $this->error("Invalid action. Use: list, assign, or remove."),
        };
    }

    protected function listUserRoles(Business $business): int
    {
        $users = $business->users()->with('role')->get();

        if ($users->isEmpty()) {
            $this->info("No users found for {$business->name}.");
            return 0;
        }

        $this->info("\nUsers and their roles for {$business->name}:");
        $this->newLine();

        foreach ($users as $user) {
            $this->info("User: {$user->name} ({$user->email})");
            if ($user->role) {
                $this->line("Role: {$user->role->name} ({$user->role->slug})");
                $this->line("Description: {$user->role->description}");
                $this->line("Default Role: " . ($user->role->is_default ? 'Yes' : 'No'));
                
                if ($user->role->permissions->isNotEmpty()) {
                    $this->line("Permissions:");
                    foreach ($user->role->permissions as $permission) {
                        $this->line("  - {$permission->name} ({$permission->slug})");
                        $this->line("    Action: {$permission->action}");
                        $this->line("    Resource: {$permission->resource_type}");
                        $this->line("    Module: {$permission->module}");
                        $this->line("    Page: {$permission->page}");
                    }
                }
            } else {
                $this->line("No role assigned");
            }
            
            $this->newLine();
        }

        return 0;
    }

    protected function assignRole(Business $business): int
    {
        $email = $this->option('email') ?? $this->ask('Enter the email of the user');
        $roleSlug = $this->option('role') ?? $this->ask('Enter the slug of the role to assign');

        $user = $business->users()->where('email', $email)->first();
        if (!$user) {
            $this->error("User not found.");
            return 1;
        }

        $role = $business->roles()->where('slug', $roleSlug)->first();
        if (!$role) {
            $this->error("Role not found.");
            return 1;
        }

        if ($user->role) {
            if (!$this->confirm("User already has a role. Do you want to replace it?")) {
                $this->info("Operation cancelled.");
                return 0;
            }
        }

        $user->assignRole($role);
        $this->info("Role '{$role->name}' assigned to user '{$user->name}' successfully.");
        return 0;
    }

    protected function removeRole(Business $business): int
    {
        $email = $this->option('email') ?? $this->ask('Enter the email of the user');

        $user = $business->users()->where('email', $email)->first();
        if (!$user) {
            $this->error("User not found.");
            return 1;
        }

        if (!$user->role) {
            $this->error("User has no role assigned.");
            return 1;
        }

        if ($this->confirm("Are you sure you want to remove the role '{$user->role->name}' from user '{$user->name}'?")) {
            $user->removeRole();
            $this->info("Role removed from user '{$user->name}' successfully.");
            return 0;
        }

        $this->info("Operation cancelled.");
        return 0;
    }
} 