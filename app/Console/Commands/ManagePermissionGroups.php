<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessPermissionGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ManagePermissionGroups extends Command
{
    protected $signature = 'business:permission-groups
                            {business : The business slug}
                            {action : The action to perform (list|create|update|delete)}
                            {--name= : The name of the permission group}
                            {--slug= : The slug of the permission group}
                            {--description= : The description of the permission group}
                            {--permissions=* : The permission IDs to assign to the group}';

    protected $description = 'Manage business permission groups';

    public function handle(): int
    {
        $business = Business::where('slug', $this->argument('business'))->first();

        if (!$business) {
            $this->error("Business not found.");
            return 1;
        }

        $action = $this->argument('action');

        return match ($action) {
            'list' => $this->listGroups($business),
            'create' => $this->createGroup($business),
            'update' => $this->updateGroup($business),
            'delete' => $this->deleteGroup($business),
            default => $this->error("Invalid action. Use: list, create, update, or delete."),
        };
    }

    protected function listGroups(Business $business): int
    {
        $groups = $business->permissionGroups()->with('permissions')->get();

        if ($groups->isEmpty()) {
            $this->info("No permission groups found for {$business->name}.");
            return 0;
        }

        $this->info("\nPermission Groups for {$business->name}:");
        $this->newLine();

        foreach ($groups as $group) {
            $this->info("Name: {$group->name}");
            $this->info("Slug: {$group->slug}");
            $this->info("Description: {$group->description}");
            $this->info('Permissions:');
            
            foreach ($group->permissions as $permission) {
                $this->line("  - {$permission->name} ({$permission->action} {$permission->resource_type})");
            }
            
            $this->newLine();
        }

        return 0;
    }

    protected function createGroup(Business $business): int
    {
        $name = $this->option('name') ?? $this->ask('Enter the name of the permission group');
        $slug = $this->option('slug') ?? Str::slug($name);
        $description = $this->option('description') ?? $this->ask('Enter the description of the permission group');

        $group = $business->permissionGroups()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description
        ]);

        $permissions = $this->option('permissions');
        if (empty($permissions)) {
            $this->info('Available permissions:');
            $availablePermissions = $business->permissions()->get();
            foreach ($availablePermissions as $permission) {
                $this->line("  {$permission->id}: {$permission->name}");
            }
            
            $permissions = $this->ask('Enter the permission IDs (comma-separated)');
            $permissions = array_map('trim', explode(',', $permissions));
        }

        $group->permissions()->attach($permissions);

        $this->info('Permission group created successfully.');
        return 0;
    }

    protected function updateGroup(Business $business): int
    {
        $slug = $this->option('slug') ?? $this->ask('Enter the slug of the permission group to update');
        
        $group = $business->permissionGroups()->where('slug', $slug)->first();
        
        if (!$group) {
            $this->error("Permission group not found.");
            return 1;
        }

        if ($group->is_system) {
            $this->error("Cannot update system permission group.");
            return 1;
        }

        $name = $this->option('name') ?? $this->ask('Enter the new name', $group->name);
        $description = $this->option('description') ?? $this->ask('Enter the new description', $group->description);
        $permissions = $this->option('permissions');

        if (empty($permissions)) {
            $this->info("Current permissions:");
            foreach ($group->permissions as $permission) {
                $this->line("  - {$permission->name} ({$permission->slug})");
            }
            
            $this->info("\nAvailable permissions:");
            $availablePermissions = $business->permissions()->pluck('name', 'slug')->toArray();
            foreach ($availablePermissions as $slug => $name) {
                $this->line("  - {$name} ({$slug})");
            }
            
            $permissions = $this->ask('Enter the new permission slugs (comma-separated)');
            $permissions = array_map('trim', explode(',', $permissions));
        }

        $group->update([
            'name' => $name,
            'description' => $description
        ]);

        $permissionIds = $business->permissions()
            ->whereIn('slug', $permissions)
            ->pluck('id')
            ->toArray();

        $group->permissions()->sync($permissionIds);

        $this->info("Permission group '{$group->name}' updated successfully.");
        return 0;
    }

    protected function deleteGroup(Business $business): int
    {
        $slug = $this->option('slug') ?? $this->ask('Enter the slug of the permission group to delete');
        
        $group = $business->permissionGroups()->where('slug', $slug)->first();
        
        if (!$group) {
            $this->error("Permission group not found.");
            return 1;
        }

        if ($group->is_system) {
            $this->error("Cannot delete system permission group.");
            return 1;
        }

        if ($this->confirm("Are you sure you want to delete the permission group '{$group->name}'?")) {
            $group->delete();
            $this->info("Permission group '{$group->name}' deleted successfully.");
            return 0;
        }

        $this->info("Operation cancelled.");
        return 0;
    }
} 