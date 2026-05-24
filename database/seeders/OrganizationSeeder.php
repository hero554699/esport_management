<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $orgs = [
            ['name' => 'Sentinels',              'slug' => 'sentinels'],
            ['name' => 'Team Liquid',            'slug' => 'team-liquid'],
            ['name' => 'Fnatic',                 'slug' => 'fnatic'],
            ['name' => 'Natus Vincere',          'slug' => 'navi'],
            ['name' => 'Cloud9',                 'slug' => 'cloud9'],
            ['name' => 'FaZe Clan',              'slug' => 'faze'],
            ['name' => 'G2 Esports',             'slug' => 'g2'],
            ['name' => 'Team Spirit',            'slug' => 'team-spirit'],
            ['name' => 'ECHO',                   'slug' => 'echo'],
            ['name' => 'Blacklist International', 'slug' => 'blacklist'],
            ['name' => 'Onic Philippines',       'slug' => 'onic-ph'],
            ['name' => 'TNC Pro Team',           'slug' => 'tnc'],
        ];

        foreach ($orgs as $org) {
            Organization::create($org);
        }
    }
}
