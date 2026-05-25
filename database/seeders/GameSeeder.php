<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        

        foreach ($games as $game) {
            // Use updateOrCreate instead of firstOrCreate
            Game::updateOrCreate(
                ['slug' => $game['slug']], // Use slug as unique identifier
                $game
            );
        }
    }
}
