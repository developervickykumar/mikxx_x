<?php

namespace App\Console\Commands;

use App\Models\TableBuilder;
use App\Services\TableBuilderService;
use Illuminate\Console\Command;

class GenerateSampleData extends Command
{
    protected $signature = 'tables:generate-sample {table_id} {--rows=10 : Number of rows to generate}';
    protected $description = 'Generate sample data for a table';

    public function handle(TableBuilderService $service)
    {
        $tableId = $this->argument('table_id');
        $rows = $this->option('rows');

        $table = TableBuilder::find($tableId);

        if (!$table) {
            $this->error("Table with ID {$tableId} not found.");
            return 1;
        }

        $this->info("Generating {$rows} rows of sample data for table: {$table->name}");
        $bar = $this->output->createProgressBar($rows);
        $bar->start();

        $data = $service->generateSampleData($table, $rows);

        $bar->finish();
        $this->newLine(2);

        $this->info('Sample data generated successfully:');
        $this->table(
            array_keys($data[0]),
            $data
        );

        return 0;
    }
} 