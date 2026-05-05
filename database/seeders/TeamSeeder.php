<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            // game_id 1 = CS2
            ['name' => 'Team Liquid CS2',      'tag' => 'LIQ',   'game_id' => 1,  'organization_id' => 2,  'country' => 'US'],
            ['name' => 'Natus Vincere CS2',    'tag' => 'NAVI',  'game_id' => 1,  'organization_id' => 4,  'country' => 'UA'],
            ['name' => 'G2 CS2',               'tag' => 'G2',    'game_id' => 1,  'organization_id' => 7,  'country' => 'DE'],
            ['name' => 'FaZe CS2',             'tag' => 'FAZE',  'game_id' => 1,  'organization_id' => 6,  'country' => 'US'],

            // game_id 2 = Valorant
            ['name' => 'Sentinels Valorant',   'tag' => 'SEN',   'game_id' => 2,  'organization_id' => 1,  'country' => 'US'],
            ['name' => 'Fnatic Valorant',      'tag' => 'FNC',   'game_id' => 2,  'organization_id' => 3,  'country' => 'GB'],
            ['name' => 'Cloud9 Valorant',      'tag' => 'C9',    'game_id' => 2,  'organization_id' => 5,  'country' => 'US'],
            ['name' => 'G2 Valorant',          'tag' => 'G2V',   'game_id' => 2,  'organization_id' => 7,  'country' => 'DE'],

            // game_id 3 = Dota 2
            ['name' => 'Team Liquid Dota2',    'tag' => 'LIQDOTA', 'game_id' => 3, 'organization_id' => 2,  'country' => 'US'],
            ['name' => 'Team Spirit Dota2',    'tag' => 'SPR',   'game_id' => 3,  'organization_id' => 8,  'country' => 'RU'],
            ['name' => 'TNC Pro Team',         'tag' => 'TNC',   'game_id' => 3,  'organization_id' => 12, 'country' => 'PH'],

            // game_id 4 = League of Legends
            ['name' => 'Sentinels LoL',        'tag' => 'SENL',  'game_id' => 4,  'organization_id' => 1,  'country' => 'US'],
            ['name' => 'Cloud9 LoL',           'tag' => 'C9L',   'game_id' => 4,  'organization_id' => 5,  'country' => 'US'],
            ['name' => 'Fnatic LoL',           'tag' => 'FNCL',  'game_id' => 4,  'organization_id' => 3,  'country' => 'GB'],

            // game_id 5 = Apex Legends
            ['name' => 'Sentinels Apex',       'tag' => 'SENA',  'game_id' => 5,  'organization_id' => 1,  'country' => 'US'],

            // game_id 8 = MLBB
            ['name' => 'ECHO MLBB',            'tag' => 'ECHO',  'game_id' => 8,  'organization_id' => 9,  'country' => 'PH'],
            ['name' => 'Blacklist MLBB',       'tag' => 'BL',    'game_id' => 8,  'organization_id' => 10, 'country' => 'PH'],
            ['name' => 'ONIC PH',              'tag' => 'ONIC',  'game_id' => 8,  'organization_id' => 11, 'country' => 'PH'],

            // game_id 9 = PUBG Mobile
            ['name' => 'Blacklist PUBGM',      'tag' => 'BLPUBG', 'game_id' => 9,  'organization_id' => 10, 'country' => 'PH'],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
