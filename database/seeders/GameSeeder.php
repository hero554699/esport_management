<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            ['name' => 'Counter-Strike 2',        'slug' => 'cs2',         'platform' => 'pc',     'is_active' => true],
            ['name' => 'Valorant',                 'slug' => 'valorant',    'platform' => 'pc',     'is_active' => true],
            ['name' => 'Dota 2',                   'slug' => 'dota2',       'platform' => 'pc',     'is_active' => true],
            ['name' => 'League of Legends',        'slug' => 'lol',         'platform' => 'pc',     'is_active' => true],
            ['name' => 'Apex Legends',             'slug' => 'apex',        'platform' => 'pc',     'is_active' => true],
            ['name' => 'Rocket League',            'slug' => 'rl',          'platform' => 'pc',     'is_active' => true],
            ['name' => 'Overwatch 2',              'slug' => 'ow2',         'platform' => 'pc',     'is_active' => true],
            ['name' => 'Mobile Legends Bang Bang', 'slug' => 'mlbb',        'platform' => 'mobile', 'is_active' => true],
            ['name' => 'PUBG Mobile',              'slug' => 'pubgm',       'platform' => 'mobile', 'is_active' => true],
            ['name' => 'Wild Rift',                'slug' => 'wildrift',    'platform' => 'mobile', 'is_active' => true],
            ['name' => 'Call of Duty Mobile',      'slug' => 'codm',        'platform' => 'mobile', 'is_active' => true],
            ['name' => 'Free Fire',                'slug' => 'freefire',    'platform' => 'mobile', 'is_active' => true],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}