<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableColumnsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table {names*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the column names of a given table';

    /**
     * Execute the console command.php
     *
     * @return int
     */
    public function handle()
    {
        // Get the table names from the command argument
        $tableNames = $this->argument('names');

        foreach ($tableNames as $tableName) {
            // Check if the table exists
            if (!Schema::hasTable($tableName)) {
                // $this->error("The table '{$tableName}' does not exist.");

                // Show available tables
                $tables = DB::select('SHOW TABLES');
                // Extract table names from the result and store them in an array
                $availableTables = [];
                foreach ($tables as $table) {
                    $tableArray = get_object_vars($table); // Get object properties
                    $availableTables[] = reset($tableArray); // Store table name
                }

                // Try to find the closest match
                $bestMatch = '';
                $highestSimilarity = 0;

                foreach ($availableTables as $availableTable) {
                    $similarity = similar_text(strtolower($tableName), strtolower($availableTable), $percent);
                    if ($percent > $highestSimilarity) {
                        $highestSimilarity = $percent;
                        $bestMatch = $availableTable;
                    }
                }

                // If the similarity is above a certain threshold, suggest the closest match
                if ($highestSimilarity >= 30) { // You can adjust the threshold as needed
                    $this->info("<fg=white>Did you mean: <fg=yellow>{$bestMatch}</>?"); // Suggest the closest match
                    $columns = Schema::getColumnListing($bestMatch);
                    foreach ($columns as $column) {
                        $type = Schema::getColumnType($bestMatch, $column);
                        if ($type === 'enum') {
                            $enumValues = DB::select("SHOW COLUMNS FROM {$bestMatch} WHERE Field = ?", [$column])[0]->Type;
                            $this->line("<fg=green>- {$column} => {$enumValues}</>");
                        } else {
                            $this->line("<fg=green>- {$column} => {$type}</>");
                        }
                    }
                } else {
                    // If no close match is found, list all available tables
                    $this->info("Showing all available tables:");
                    foreach ($availableTables as $availableTable) {
                        $this->line("<fg=cyan>- {$availableTable}</>");
                    }
                }

                continue;
            }

            // If table exists, get the column names
            $columns = Schema::getColumnListing($tableName);

            // Display the column names for the existing table
            $this->info("<fg=white;options=bold>{$tableName}</>");
            foreach ($columns as $column) {
                $type = Schema::getColumnType($tableName, $column);
                if ($type === 'enum') {
                    $enumValues = DB::select("SHOW COLUMNS FROM {$tableName} WHERE Field = ?", [$column])[0]->Type;
                    $this->line("<fg=green>- {$column} => {$enumValues}</>");
                } else {
                    $this->line("<fg=green>- {$column} => {$type}</>");
                }
            }

            $this->line(''); // Adds a blank line for readability
        }

        return 0;
    }
}
