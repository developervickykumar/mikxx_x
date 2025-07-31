<?php

namespace App\Console\Commands;

use App\Models\TableBuilder;
use App\Services\TableBuilderService;
use Illuminate\Console\Command;

class BackupTables extends Command
{
    protected $signature = 'tables:backup {--all : Backup all tables} {--id= : Backup specific table by ID}';
    protected $description = 'Backup table builder tables';

    public function handle(TableBuilderService $service)
    {
        if ($this->option('all')) {
            $tables = TableBuilder::all();
            $this->info('Starting backup of all tables...');
        } elseif ($id = $this->option('id')) {
            $tables = TableBuilder::where('id', $id)->get();
            $this->info("Starting backup of table ID: {$id}...");
        } else {
            $this->error('Please specify --all or --id option');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($tables));
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($tables as $table) {
            if ($service->createBackup($table)) {
                $successCount++;
            } else {
                $errorCount++;
                $this->newLine();
                $this->error("Failed to backup table: {$table->name}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Backup completed:");
        $this->info("- Successfully backed up: {$successCount} tables");
        if ($errorCount > 0) {
            $this->error("- Failed to backup: {$errorCount} tables");
        }

        return 0;
    }
} 