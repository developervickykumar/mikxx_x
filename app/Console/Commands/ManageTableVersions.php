<?php

namespace App\Console\Commands;

use App\Models\TableBuilder;
use Illuminate\Console\Command;

class ManageTableVersions extends Command
{
    protected $signature = 'tables:versions {action : Action to perform (list|create|restore)} {table_id} {--version= : Version number for restore}';
    protected $description = 'Manage table versions';

    public function handle()
    {
        $action = $this->argument('action');
        $tableId = $this->argument('table_id');

        $table = TableBuilder::find($tableId);

        if (!$table) {
            $this->error("Table with ID {$tableId} not found.");
            return 1;
        }

        return match ($action) {
            'list' => $this->listVersions($table),
            'create' => $this->createVersion($table),
            'restore' => $this->restoreVersion($table),
            default => $this->error('Invalid action. Use: list, create, or restore'),
        };
    }

    protected function listVersions(TableBuilder $table): int
    {
        $versions = $table->versions()->orderBy('version', 'desc')->get();

        if ($versions->isEmpty()) {
            $this->info('No versions found for this table.');
            return 0;
        }

        $this->info("Versions for table: {$table->name}");
        $this->table(
            ['Version', 'Created At', 'Updated At'],
            $versions->map(fn ($v) => [
                'Version' => $v->version,
                'Created At' => $v->created_at,
                'Updated At' => $v->updated_at,
            ])
        );

        return 0;
    }

    protected function createVersion(TableBuilder $table): int
    {
        try {
            $newVersion = $table->replicate();
            $newVersion->version = $table->version + 1;
            $newVersion->parent_id = $table->id;
            $newVersion->save();

            $this->info("Created new version {$newVersion->version} for table: {$table->name}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create version: {$e->getMessage()}");
            return 1;
        }
    }

    protected function restoreVersion(TableBuilder $table): int
    {
        $version = $this->option('version');

        if (!$version) {
            $this->error('Please specify a version number using --version option');
            return 1;
        }

        $versionTable = $table->versions()->where('version', $version)->first();

        if (!$versionTable) {
            $this->error("Version {$version} not found for table: {$table->name}");
            return 1;
        }

        try {
            $table->update([
                'columns' => $versionTable->columns,
                'validation_rules' => $versionTable->validation_rules,
                'column_dependencies' => $versionTable->column_dependencies,
                'column_comments' => $versionTable->column_comments,
                'column_order' => $versionTable->column_order,
            ]);

            $this->info("Restored version {$version} for table: {$table->name}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to restore version: {$e->getMessage()}");
            return 1;
        }
    }
} 