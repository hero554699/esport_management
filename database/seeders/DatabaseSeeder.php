<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GameSeeder::class,
            OrganizationSeeder::class,
            TeamSeeder::class,
            PlayerSeeder::class,
            EventSeeder::class,
            MatchesSeeder::class,
            ResultSeeder::class,
        ]);
    }
}
