<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefreshTable extends Command
{
    protected $signature = 'table:refresh {migration : The name of the migration file}';

    protected $description = 'Refresh a table by dropping it, removing the migration record, and rerunning the migration';

    public function handle(): void
    {
        $migrationFileName = Str::remove('.php' , $this->argument('migration'));
        $tableName = $this->extractTableName($migrationFileName);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->info("Dropping table $tableName...");
        DB::statement("DROP TABLE IF EXISTS $tableName");

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info("Deleting migration record for $migrationFileName...");
        DB::table('migrations')->where('migration', $migrationFileName)->delete();

        $this->info("Running migration for $tableName...");
        $this->call('migrate');

        $this->info("Table $tableName has been refreshed successfully!");
    }

    protected function extractTableName($migrationFileName)
    {
        // Extracting table name from the migration file name.
        // Assumes migration file name is in the format YYYY_MM_DD_HHMMSS_create_table_name.php
        preg_match('/create_(\w+)_table/', $migrationFileName, $matches);

        if (count($matches) == 2) {
            return $matches[1];
        }

        $this->error("Unable to extract table name from migration file name.");
        exit(1);
    }
}
