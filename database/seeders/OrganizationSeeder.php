<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $orgs = [
            ['name' => 'Sentinels',              'slug' => 'sentinels',    'country' => 'US', 'website' => 'https://sentinels.gg'],
            ['name' => 'Team Liquid',            'slug' => 'team-liquid',  'country' => 'US', 'website' => 'https://teamliquid.com'],
            ['name' => 'Fnatic',                 'slug' => 'fnatic',       'country' => 'GB', 'website' => 'https://fnatic.com'],
            ['name' => 'Natus Vincere',          'slug' => 'navi',         'country' => 'UA', 'website' => 'https://navi.gg'],
            ['name' => 'Cloud9',                 'slug' => 'cloud9',       'country' => 'US', 'website' => 'https://cloud9.gg'],
            ['name' => 'FaZe Clan',              'slug' => 'faze',         'country' => 'US', 'website' => 'https://fazeclan.com'],
            ['name' => 'G2 Esports',             'slug' => 'g2',           'country' => 'DE', 'website' => 'https://g2esports.com'],
            ['name' => 'Team Spirit',            'slug' => 'team-spirit',  'country' => 'RU', 'website' => 'https://teamspirit.gg'],
            ['name' => 'ECHO',                   'slug' => 'echo',         'country' => 'PH', 'website' => 'https://echo.ph'],
            ['name' => 'Blacklist International', 'slug' => 'blacklist',    'country' => 'PH', 'website' => 'https://blacklist.gg'],
            ['name' => 'Onic Philippines',       'slug' => 'onic-ph',      'country' => 'PH', 'website' => 'https://onicph.com'],
            ['name' => 'TNC Pro Team',           'slug' => 'tnc',          'country' => 'PH', 'website' => 'https://tncpro.com'],
        ];

        foreach ($orgs as $org) {
            Organization::create($org);
        }
    }
}
