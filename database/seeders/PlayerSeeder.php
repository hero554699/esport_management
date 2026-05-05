<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        $players = [
            // Sentinels Valorant (team_id 5)
            ['team_id' => 5, 'username' => 'johnqt',   'real_name' => 'Mohamed Amine Ouarid', 'country' => 'MA', 'role' => 'IGL'],
            ['team_id' => 5, 'username' => 'zekken',   'real_name' => 'Zachary Patrone',      'country' => 'US', 'role' => 'Duelist'],
            ['team_id' => 5, 'username' => 'bang',     'real_name' => 'Sean Bezerra',         'country' => 'US', 'role' => 'Initiator'],
            ['team_id' => 5, 'username' => 'JonahP',   'real_name' => 'Jonah Pulice',         'country' => 'US', 'role' => 'Flex'],
            ['team_id' => 5, 'username' => 'Jerrwin',  'real_name' => 'Jerrwin Valencia',     'country' => 'PH', 'role' => 'Duelist'],

            // Natus Vincere CS2 (team_id 2)
            ['team_id' => 2, 'username' => 's1mple',   'real_name' => 'Oleksandr Kostyliev',  'country' => 'UA', 'role' => 'AWPer'],
            ['team_id' => 2, 'username' => 'b1t',      'real_name' => 'Valerii Vakhovskyi',   'country' => 'UA', 'role' => 'Rifler'],
            ['team_id' => 2, 'username' => 'jL',       'real_name' => 'Justinas Lekavicius',  'country' => 'LT', 'role' => 'Rifler'],

            // G2 CS2 (team_id 3)
            ['team_id' => 3, 'username' => 'NiKo',     'real_name' => 'Nikola Kovac',         'country' => 'BA', 'role' => 'Rifler'],
            ['team_id' => 3, 'username' => 'm0NESY',   'real_name' => 'Ilya Osipov',          'country' => 'RU', 'role' => 'AWPer'],

            // ECHO MLBB (team_id 16)
            ['team_id' => 16, 'username' => 'Kairi',     'real_name' => 'Kairi Rayosdelsol',  'country' => 'PH', 'role' => 'Jungler'],
            ['team_id' => 16, 'username' => 'Yawi',      'real_name' => 'Karl Nepomuceno',    'country' => 'PH', 'role' => 'Support'],
            ['team_id' => 16, 'username' => 'Sanford',   'real_name' => 'Sanford Vinuya',     'country' => 'PH', 'role' => 'Gold Lane'],
            ['team_id' => 16, 'username' => 'Halcyon',   'real_name' => 'Bright Romen',       'country' => 'PH', 'role' => 'EXP Lane'],
            ['team_id' => 16, 'username' => 'Butss',     'real_name' => 'Karl Patino',        'country' => 'PH', 'role' => 'Roamer'],

            // Blacklist MLBB (team_id 17)
            ['team_id' => 17, 'username' => 'OhMyV33nus', 'real_name' => 'Johnmar Villaluna',  'country' => 'PH', 'role' => 'Roamer'],
            ['team_id' => 17, 'username' => 'Wise',      'real_name' => 'Edward Equiatan',    'country' => 'PH', 'role' => 'Midlaner'],
            ['team_id' => 17, 'username' => 'Hampus',    'real_name' => 'Hampus Pokorny',     'country' => 'PH', 'role' => 'Gold Lane'],

            // ONIC PH MLBB (team_id 18)
            ['team_id' => 18, 'username' => 'Sanz',      'real_name' => 'Sanz Rivas',         'country' => 'PH', 'role' => 'Jungler'],
            ['team_id' => 18, 'username' => 'Lightr',    'real_name' => 'Lightr Go',          'country' => 'PH', 'role' => 'Gold Lane'],
        ];

        foreach ($players as $player) {
            Player::create($player);
        }
    }
}
