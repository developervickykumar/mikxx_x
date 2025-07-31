<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessRole;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ManageRoles extends Command
{
    protected $signature = 'business:roles
                            {business : The business slug}
                            {action : The action to perform (list|create|update|delete)}
                            {--name= : The name of the role}
                            {--slug= : The slug of the role}
                            {--description= : The description of the role}
                            {--permissions=* : The permissions to assign to the role}
                            {--is-default : Whether this is a default role}';

    protected $description = 'Manage business roles';

    public function handle(): int
    {
        $business = Business::where('slug', $this->argument('business'))->first();

        if (!$business) {
            $this->error("Business not found.");
            return 1;
        }

        $action = $this->argument('action');

        return match ($action) {
            'list' => $this->listRoles($business),
            'create' => $this->createRole($business),
            'update' => $this->updateRole($business),
            'delete' => $this->deleteRole($business),
            default => $this->error("Invalid action. Use: list, create, update, or delete."),
        };
    }

    protected function listRoles(Business $business): int
    {
        $roles = $business->roles()->with('permissions')->get();

        if ($roles->isEmpty()) {
            $this->info("No roles found for {$business->name}.");
            return 0;
        }

        $this->info("\nRoles for {$business->name}:");
        $this->newLine();

        foreach ($roles as $role) {
            $this->info("Role: {$role->name} ({$role->slug})");
            $this->line("Description: {$role->description}");
            $this->line("Default Role: " . ($role->is_default ? 'Yes' : 'No'));
            
            if ($role->permissions->isNotEmpty()) {
                $this->line("Permissions:");
                foreach ($role->permissions as $permission) {
                    $this->line("  - {$permission->name} ({$permission->slug})");
                    $this->line("    Action: {$permission->action}");
                    $this->line("    Resource: {$permission->resource_type}");
                    $this->line("    Module: {$permission->module}");
                    $this->line("    Page: {$permission->page}");
                }
            }
            
            $this->newLine();
        }

        return 0;
    }

    protected function createRole(Business $business): int
    {
        $name = $this->option('name') ?? $this->ask('Enter the name of the role');
        $slug = $this->option('slug') ?? Str::slug($name);
        $description = $this->option('description') ?? $this->ask('Enter the description of the role');
        $isDefault = $this->option('is-default') ?? $this->confirm('Is this a default role?');
        $permissions = $this->option('permissions');

        if (empty($permissions)) {
            $this->info("Available permissions:");
            $availablePermissions = $business->permissions()
                ->orderBy('module')
                ->orderBy('name')
                ->get()
                ->groupBy('module');

            foreach ($availablePermissions as $module => $modulePermissions) {
                $this->info("\nModule: {$module}");
                foreach ($modulePermissions as $permission) {
                    $this->line("  - {$permission->name} ({$permission->slug})");
                    $this->line("    Action: {$permission->action}");
                    $this->line("    Resource: {$permission->resource_type}");
                    $this->line("    Page: {$permission->page}");
                }
            }
            
            $permissions = $this->ask('Enter the permission slugs (comma-separated)');
            $permissions = array_map('trim', explode(',', $permissions));
        }

        $role = BusinessRole::create([
            'business_id' => $business->id,
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'is_default' => $isDefault
        ]);

        $permissionIds = $business->permissions()
            ->whereIn('slug', $permissions)
            ->pluck('id')
            ->toArray();

        $role->permissions()->attach($permissionIds);

        $this->info("Role '{$role->name}' created successfully.");
        return 0;
    }

    protected function updateRole(Business $business): int
    {
        $slug = $this->option('slug') ?? $this->ask('Enter the slug of the role to update');
        
        $role = $business->roles()->where('slug', $slug)->first();
        
        if (!$role) {
            $this->error("Role not found.");
            return 1;
        }

        if ($role->is_default && !$this->option('is-default')) {
            $this->error("Cannot remove default status from a default role.");
            return 1;
        }

        $name = $this->option('name') ?? $this->ask('Enter the new name', $role->name);
        $description = $this->option('description') ?? $this->ask('Enter the new description', $role->description);
        $isDefault = $this->option('is-default') ?? $role->is_default;
        $permissions = $this->option('permissions');

        if (empty($permissions)) {
            $this->info("Current permissions:");
            foreach ($role->permissions as $permission) {
                $this->line("  - {$permission->name} ({$permission->slug})");
                $this->line("    Action: {$permission->action}");
                $this->line("    Resource: {$permission->resource_type}");
                $this->line("    Module: {$permission->module}");
                $this->line("    Page: {$permission->page}");
            }
            
            $this->info("\nAvailable permissions:");
            $availablePermissions = $business->permissions()
                ->orderBy('module')
                ->orderBy('name')
                ->get()
                ->groupBy('module');

            foreach ($availablePermissions as $module => $modulePermissions) {
                $this->info("\nModule: {$module}");
                foreach ($modulePermissions as $permission) {
                    $this->line("  - {$permission->name} ({$permission->slug})");
                    $this->line("    Action: {$permission->action}");
                    $this->line("    Resource: {$permission->resource_type}");
                    $this->line("    Page: {$permission->page}");
                }
            }
            
            $permissions = $this->ask('Enter the new permission slugs (comma-separated)');
            $permissions = array_map('trim', explode(',', $permissions));
        }

        $role->update([
            'name' => $name,
            'description' => $description,
            'is_default' => $isDefault
        ]);

        $permissionIds = $business->permissions()
            ->whereIn('slug', $permissions)
            ->pluck('id')
            ->toArray();

        $role->permissions()->sync($permissionIds);

        $this->info("Role '{$role->name}' updated successfully.");
        return 0;
    }

    protected function deleteRole(Business $business): int
    {
        $slug = $this->option('slug') ?? $this->ask('Enter the slug of the role to delete');
        
        $role = $business->roles()->where('slug', $slug)->first();
        
        if (!$role) {
            $this->error("Role not found.");
            return 1;
        }

        if ($role->is_default) {
            $this->error("Cannot delete a default role.");
            return 1;
        }

        if ($this->confirm("Are you sure you want to delete the role '{$role->name}'?")) {
            $role->delete();
            $this->info("Role '{$role->name}' deleted successfully.");
            return 0;
        }

        $this->info("Operation cancelled.");
        return 0;
    }
} 