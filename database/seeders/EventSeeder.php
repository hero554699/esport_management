<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'game_id'    => 2,
                'user_id'    => 1,
                'name'       => 'VCT 2026 Americas Kickoff',
                'slug'       => 'vct-2026-americas-kickoff',
                'status'     => 'completed',
                'start_date' => '2026-01-18',
                'end_date'   => '2026-02-09',
                'prize_pool' => '$200,000',
            ],
            [
                'game_id'    => 8,
                'user_id'    => 1,
                'name'       => 'MPL Philippines Season 15',
                'slug'       => 'mpl-ph-s15',
                'status'     => 'live',
                'start_date' => '2026-03-01',
                'end_date'   => '2026-04-30',
                'prize_pool' => '₱3,000,000',
            ],
            [
                'game_id'    => 1,
                'user_id'    => 1,
                'name'       => 'PGL Bucharest 2026',
                'slug'       => 'pgl-bucharest-2026',
                'status'     => 'live',
                'start_date' => '2026-03-26',
                'end_date'   => '2026-04-06',
                'prize_pool' => '$1,250,000',
            ],
            [
                'game_id'    => 2,
                'user_id'    => 1,
                'name'       => 'VCT 2026 Masters Bangkok',
                'slug'       => 'vct-2026-masters-bangkok',
                'status'     => 'upcoming',
                'start_date' => '2026-06-01',
                'end_date'   => '2026-06-15',
                'prize_pool' => '$500,000',
            ],
            [
                'game_id'    => 3,
                'user_id'    => 1,
                'name'       => 'The International 2026',
                'slug'       => 'ti-2026',
                'status'     => 'upcoming',
                'start_date' => '2026-09-01',
                'end_date'   => '2026-09-15',
                'prize_pool' => '$15,000,000',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
