<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessPermission;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ManagePermissions extends Command
{
    protected $signature = 'business:permissions 
        {business : The business slug}
        {action : The action to perform (list|create|update|delete)}
        {--name= : The name of the permission}
        {--slug= : The slug of the permission}
        {--description= : The description of the permission}
        {--action= : The action type (view|create|update|delete)}
        {--resource-type= : The resource type (content|reports|settings|users)}
        {--module= : The module name}
        {--group= : The permission group slug}';

    protected $description = 'Manage business permissions';

    public function handle()
    {
        $business = Business::where('slug', $this->argument('business'))->first();

        if (!$business) {
            $this->error('Business not found.');
            return 1;
        }

        $action = $this->argument('action');

        return match ($action) {
            'list' => $this->listPermissions($business),
            'create' => $this->createPermission($business),
            'update' => $this->updatePermission($business),
            'delete' => $this->deletePermission($business),
            default => $this->error('Invalid action.'),
        };
    }

    protected function listPermissions(Business $business): int
    {
        $permissions = $business->permissions()->with('groups')->get();

        if ($permissions->isEmpty()) {
            $this->info('No permissions found.');
            return 0;
        }

        $this->info('Permissions:');
        $this->newLine();

        foreach ($permissions as $permission) {
            $this->info("Name: {$permission->name}");
            $this->info("Slug: {$permission->slug}");
            $this->info("Description: {$permission->description}");
            $this->info("Action: {$permission->action}");
            $this->info("Resource Type: {$permission->resource_type}");
            $this->info("Module: {$permission->module}");
            
            if ($permission->groups->isNotEmpty()) {
                $this->info('Groups:');
                foreach ($permission->groups as $group) {
                    $this->line("  - {$group->name}");
                }
            }
            
            $this->newLine();
        }

        return 0;
    }

    protected function createPermission(Business $business): int
    {
        $name = $this->option('name') ?? $this->ask('Enter the name of the permission');
        $slug = $this->option('slug') ?? Str::slug($name);
        $description = $this->option('description') ?? $this->ask('Enter the description of the permission');
        
        $action = $this->option('action') ?? $this->choice(
            'Select the action type',
            ['view', 'create', 'update', 'delete']
        );
        
        $resourceType = $this->option('resource-type') ?? $this->choice(
            'Select the resource type',
            ['content', 'reports', 'settings', 'users']
        );
        
        $module = $this->option('module') ?? $this->ask('Enter the module name');

        $permission = $business->permissions()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'action' => $action,
            'resource_type' => $resourceType,
            'module' => $module
        ]);

        $groupSlug = $this->option('group');
        if (empty($groupSlug)) {
            $this->info('Available permission groups:');
            $groups = $business->permissionGroups()->get();
            foreach ($groups as $group) {
                $this->line("  {$group->slug}: {$group->name}");
            }
            
            if ($this->confirm('Do you want to assign this permission to a group?')) {
                $groupSlug = $this->ask('Enter the group slug');
            }
        }

        if ($groupSlug) {
            $group = $business->permissionGroups()->where('slug', $groupSlug)->first();
            if ($group) {
                $group->permissions()->attach($permission->id);
            } else {
                $this->warn("Group '{$groupSlug}' not found.");
            }
        }

        $this->info('Permission created successfully.');
        return 0;
    }

    protected function updatePermission(Business $business): int
    {
        $slug = $this->option('slug') ?? $this->ask('Enter the slug of the permission to update');
        
        $permission = $business->permissions()->where('slug', $slug)->first();
        if (!$permission) {
            $this->error('Permission not found.');
            return 1;
        }

        $name = $this->option('name') ?? $this->ask('Enter the new name', $permission->name);
        $newSlug = $this->option('slug') ?? Str::slug($name);
        $description = $this->option('description') ?? $this->ask('Enter the new description', $permission->description);
        
        $action = $this->option('action') ?? $this->choice(
            'Select the new action type',
            ['view', 'create', 'update', 'delete'],
            array_search($permission->action, ['view', 'create', 'update', 'delete'])
        );
        
        $resourceType = $this->option('resource-type') ?? $this->choice(
            'Select the new resource type',
            ['content', 'reports', 'settings', 'users'],
            array_search($permission->resource_type, ['content', 'reports', 'settings', 'users'])
        );
        
        $module = $this->option('module') ?? $this->ask('Enter the new module name', $permission->module);

        $permission->update([
            'name' => $name,
            'slug' => $newSlug,
            'description' => $description,
            'action' => $action,
            'resource_type' => $resourceType,
            'module' => $module
        ]);

        $groupSlug = $this->option('group');
        if (empty($groupSlug)) {
            $this->info('Current groups:');
            foreach ($permission->groups as $group) {
                $this->line("  - {$group->name} ({$group->slug})");
            }
            
            $this->info('Available permission groups:');
            $groups = $business->permissionGroups()->get();
            foreach ($groups as $group) {
                $this->line("  {$group->slug}: {$group->name}");
            }
            
            if ($this->confirm('Do you want to update the group assignment?')) {
                $groupSlug = $this->ask('Enter the new group slug');
            }
        }

        if ($groupSlug) {
            $group = $business->permissionGroups()->where('slug', $groupSlug)->first();
            if ($group) {
                $permission->groups()->sync([$group->id]);
            } else {
                $this->warn("Group '{$groupSlug}' not found.");
            }
        }

        $this->info('Permission updated successfully.');
        return 0;
    }

    protected function deletePermission(Business $business): int
    {
        $slug = $this->option('slug') ?? $this->ask('Enter the slug of the permission to delete');
        
        $permission = $business->permissions()->where('slug', $slug)->first();
        if (!$permission) {
            $this->error('Permission not found.');
            return 1;
        }

        if ($this->confirm("Are you sure you want to delete the permission '{$permission->name}'?")) {
            $permission->delete();
            $this->info('Permission deleted successfully.');
        }

        return 0;
    }
} 