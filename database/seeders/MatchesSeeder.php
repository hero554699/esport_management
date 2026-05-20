<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MatchesSeeder extends Seeder
{
    public function run(): void
    {
        // Matches are created by users/admin through the dashboard
        // PandaScore matches are synced via: php artisan pandascore:sync --type=matches
    }
}