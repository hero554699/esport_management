<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            ['name' => 'Counter Strike 2', 'slug' => 'cs2', 'platform' => 'pc', 'is_active' => true],
            ['name' => 'VALORANT', 'slug' => 'valorant', 'platform' => 'pc', 'is_active' => true],
            ['name' => 'League of Legends', 'slug' => 'lol', 'platform' => 'pc', 'is_active' => true],
            ['name' => 'Mobile Legends', 'slug' => 'ml', 'platform' => 'mobile', 'is_active' => true],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(
                ['slug' => $game['slug']],
                $game
            );
        }
    }
}
