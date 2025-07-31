<?php

namespace App\Services;

use App\Models\TableBuilder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TableBuilderService
{
    public function duplicateTable(TableBuilder $table, User $user): TableBuilder
    {
        return DB::transaction(function () use ($table, $user) {
            $newTable = $table->replicate();
            $newTable->name = $table->name . ' (Copy)';
            $newTable->user_id = $user->id;
            $newTable->parent_id = $table->id;
            $newTable->version = 1;
            $newTable->save();

            // Copy related data
            $this->copyRelatedData($table, $newTable);

            return $newTable;
        });
    }

    public function createFromTemplate(TableBuilder $template, User $user): TableBuilder
    {
        return DB::transaction(function () use ($template, $user) {
            $table = $template->replicate();
            $table->name = $template->name . ' (New)';
            $table->user_id = $user->id;
            $table->is_template = false;
            $table->version = 1;
            $table->save();

            // Copy related data
            $this->copyRelatedData($template, $table);

            return $table;
        });
    }

    public function createBackup(TableBuilder $table): bool
    {
        try {
            $backupData = [
                'table' => $table->toArray(),
                'forms' => $table->forms->toArray(),
                'graphs' => $table->graphs->toArray(),
                'timestamp' => now()
            ];

            $filename = "backup_{$table->id}_" . now()->format('Y-m-d_His') . '.json';
            $path = "table-backups/{$filename}";

            Storage::put($path, json_encode($backupData, JSON_PRETTY_PRINT));

            $table->update([
                'last_backup_at' => now(),
                'backup_path' => $path
            ]);

            return true;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function restoreFromBackup(TableBuilder $table, string $backupPath): bool
    {
        try {
            if (!Storage::exists($backupPath)) {
                return false;
            }

            $backupData = json_decode(Storage::get($backupPath), true);

            return DB::transaction(function () use ($table, $backupData) {
                // Restore table data
                $table->update($backupData['table']);

                // Restore forms
                if (isset($backupData['forms'])) {
                    foreach ($backupData['forms'] as $formData) {
                        $table->forms()->updateOrCreate(
                            ['id' => $formData['id']],
                            $formData
                        );
                    }
                }

                // Restore graphs
                if (isset($backupData['graphs'])) {
                    foreach ($backupData['graphs'] as $graphData) {
                        $table->graphs()->updateOrCreate(
                            ['id' => $graphData['id']],
                            $graphData
                        );
                    }
                }

                return true;
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function generateSampleData(TableBuilder $table, int $rows = 10): array
    {
        $data = [];
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $rows; $i++) {
            $row = [];
            foreach ($table->columns as $column) {
                $row[$column['name']] = $this->generateSampleValue($column, $faker);
            }
            $data[] = $row;
        }

        return $data;
    }

    public function importData(TableBuilder $table, array $data): bool
    {
        try {
            DB::beginTransaction();

            foreach ($data as $row) {
                // Validate data
                $table->validateTableData($row);
                $table->validateColumnDependencies($row);

                // Insert data
                DB::table(Str::snake($table->name))->insert($row);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return false;
        }
    }

    public function exportData(TableBuilder $table, array $filters = []): array
    {
        $query = DB::table(Str::snake($table->name));

        // Apply filters
        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, $value);
            }
        }

        return $query->get()->toArray();
    }

    public function migrateData(TableBuilder $sourceTable, TableBuilder $targetTable): bool
    {
        try {
            DB::beginTransaction();

            // Get source data
            $sourceData = DB::table(Str::snake($sourceTable->name))->get();

            // Map columns
            $columnMap = $this->mapColumns($sourceTable, $targetTable);

            // Transform and insert data
            foreach ($sourceData as $row) {
                $transformedData = [];
                foreach ($columnMap as $sourceColumn => $targetColumn) {
                    $transformedData[$targetColumn] = $row->$sourceColumn;
                }

                // Validate transformed data
                $targetTable->validateTableData($transformedData);
                $targetTable->validateColumnDependencies($transformedData);

                // Insert into target table
                DB::table(Str::snake($targetTable->name))->insert($transformedData);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return false;
        }
    }

    protected function copyRelatedData(TableBuilder $source, TableBuilder $target): void
    {
        // Copy forms
        foreach ($source->forms as $form) {
            $newForm = $form->replicate();
            $newForm->table_builder_id = $target->id;
            $newForm->save();
        }

        // Copy graphs
        foreach ($source->graphs as $graph) {
            $newGraph = $graph->replicate();
            $newGraph->table_builder_id = $target->id;
            $newGraph->save();
        }
    }

    protected function generateSampleValue(array $column, $faker): mixed
    {
        return match ($column['type']) {
            'text' => $faker->sentence(),
            'number' => $faker->numberBetween(1, 1000),
            'decimal' => $faker->randomFloat(2, 0, 1000),
            'date' => $faker->date(),
            'datetime' => $faker->dateTime(),
            'boolean' => $faker->boolean(),
            default => $faker->word(),
        };
    }

    protected function mapColumns(TableBuilder $source, TableBuilder $target): array
    {
        $map = [];
        foreach ($source->columns as $sourceColumn) {
            $targetColumn = collect($target->columns)->first(function ($col) use ($sourceColumn) {
                return $col['name'] === $sourceColumn['name'] && $col['type'] === $sourceColumn['type'];
            });

            if ($targetColumn) {
                $map[$sourceColumn['name']] = $targetColumn['name'];
            }
        }
        return $map;
    }
} 