<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Result;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        Result::create([
            'match_id'       => 1,
            'winner_team_id' => 5,
            'score_a'        => 2,
            'score_b'        => 0,
            'mvp_player'     => 'johnqt',
            'notes'          => 'Sentinels dominated the VCT Americas Kickoff final.',
        ]);
    }
}
