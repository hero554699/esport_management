<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matches;

class MatchesSeeder extends Seeder
{
    public function run(): void
    {
        $matches = [
            [
                'event_id'     => 1,
                'team_a_id'    => 5,
                'team_b_id'    => 7,
                'stage'        => 'final',
                'status'       => 'completed',
                'scheduled_at' => '2026-02-09 18:00:00',
            ],
            [
                'event_id'     => 2,
                'team_a_id'    => 16,
                'team_b_id'    => 17,
                'stage'        => 'semifinal',
                'status'       => 'live',
                'scheduled_at' => '2026-04-01 15:00:00',
            ],
            [
                'event_id'     => 3,
                'team_a_id'    => 2,
                'team_b_id'    => 3,
                'stage'        => 'group',
                'status'       => 'live',
                'scheduled_at' => '2026-03-28 20:00:00',
            ],
            [
                'event_id'     => 4,
                'team_a_id'    => 5,
                'team_b_id'    => 6,
                'stage'        => 'group',
                'status'       => 'upcoming',
                'scheduled_at' => '2026-06-02 14:00:00',
            ],
        ];

        foreach ($matches as $match) {
            Matches::create($match);
        }
    }
}
