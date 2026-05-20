<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        // Results are created when matches are completed
        // PandaScore results are synced via: php artisan pandascore:sync --type=matches
    }
}