<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Events are created by users through the dashboard (pending admin approval)
        // PandaScore tournaments are synced via: php artisan pandascore:sync --type=tournaments
    }
}