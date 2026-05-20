<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        // Players are created by users inside their teams
        // PandaScore players are synced via: php artisan pandascore:sync --type=players
    }
}