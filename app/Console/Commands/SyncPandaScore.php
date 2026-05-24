<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PandaScoreService;
use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use App\Models\Event;
use App\Models\Matches;
use App\Models\Result;
use Illuminate\Support\Str;

class SyncPandaScore extends Command
{
    protected $signature = 'pandascore:sync
                            {--type=all : What to sync: all|games|teams|players|tournaments|matches}';

    protected $description = 'Sync data from PandaScore API into the database';

    public function handle(PandaScoreService $service): int
    {
        $type = $this->option('type');

        $this->info("PandaScore sync starting - type: {$type}");
        $this->newLine();

        if (in_array($type, ['all', 'games'])) {
            $this->syncGames($service);
        }

        if (in_array($type, ['all', 'teams'])) {
            $this->syncTeams($service);
        }

        if (in_array($type, ['all', 'players'])) {
            $this->syncPlayers($service);
        }

        if (in_array($type, ['all', 'tournaments'])) {
            $this->syncTournaments($service);
        }

        if (in_array($type, ['all', 'matches'])) {
            $this->syncMatches($service);
        }

        $this->newLine();
        $this->info('Sync complete!');

        return self::SUCCESS;
    }

    private function syncGames(PandaScoreService $service): void
    {
        $this->line('-> Syncing games...');

        $games = $service->getGames();
        $count = 0;

        foreach ($games as $g) {
            $slug = $g['slug'] ?? Str::slug($g['name']);

            $existing = Game::where('slug', $slug)
                            ->whereNull('pandascore_id')
                            ->first();

            if ($existing) {
                $existing->update([
                    'pandascore_id' => (string) $g['id'],
                    'is_active'     => true,
                ]);
                $count++;
                continue;
            }

            Game::updateOrCreate(
                ['pandascore_id' => (string) $g['id']],
                [
                    'name'      => $g['name'],
                    'slug'      => $slug,
                    'is_active' => true,
                ]
            );
            $count++;
        }

        $this->info("  {$count} games synced");
    }

    private function syncTeams(PandaScoreService $service): void
    {
        $this->line('-> Syncing teams...');
        $count = 0;
        $page  = 1;

        while (true) {
            $teams = $service->getTeams($page);
            if (empty($teams)) break;

            foreach ($teams as $t) {
                $slug    = $t['slug'] ?? Str::slug($t['name']);
                $acronym = isset($t['acronym']) ? substr($t['acronym'], 0, 10) : null;

                Team::updateOrCreate(
                    ['pandascore_id' => (string) $t['id']],
                    [
                        'name'     => $t['name'],
                        'slug'     => $slug,
                        'acronym'  => $acronym,
                        'tag'      => $acronym,
                        'logo_url' => $t['image_url'] ?? null,
                        'location' => $t['location'] ?? null,
                    ]
                );
                $count++;
            }

            if ($page >= 10) break;
            $page++;
        }

        $this->info("  {$count} teams synced");
    }

    private function syncPlayers(PandaScoreService $service): void
    {
        $this->line('-> Syncing players...');
        $count = 0;
        $page  = 1;

        while (true) {
            $players = $service->getPlayers($page);
            if (empty($players)) break;

            foreach ($players as $p) {
                $team = isset($p['current_team']['id'])
                    ? Team::where('pandascore_id', (string) $p['current_team']['id'])->first()
                    : null;

                $firstName = $p['first_name'] ?? '';
                $lastName  = $p['last_name'] ?? '';
                $realName  = trim($firstName . ' ' . $lastName) ?: null;

                Player::updateOrCreate(
                    ['pandascore_id' => (string) $p['id']],
                    [
                        'nickname'    => $p['name'] ?? null,
                        'username'    => $p['name'] ?? null,
                        'first_name'  => $p['first_name'] ?? null,
                        'last_name'   => $p['last_name'] ?? null,
                        'real_name'   => $realName,
                        'nationality' => $p['nationality'] ?? null,
                        'country'     => $p['nationality'] ?? null,
                        'avatar_url'  => $p['image_url'] ?? null,
                        'role'        => $p['role'] ?? null,
                        'team_id'     => $team?->id ?? null,
                    ]
                );
                $count++;
            }

            if ($page >= 10) break;
            $page++;
        }

        $this->info("  {$count} players synced");
    }

    private function syncTournaments(PandaScoreService $service): void
    {
        $this->line('-> Syncing tournaments...');

        $tournaments = array_merge(
            $service->getLiveTournaments(),
            $service->getUpcomingTournaments(),
            $service->getPastTournaments()
        );

        $count = 0;

        foreach ($tournaments as $t) {
            $game = isset($t['videogame']['id'])
                ? Game::where('pandascore_id', (string) $t['videogame']['id'])->first()
                : null;

            $slug = $t['slug'] ?? Str::slug($t['name']);

            $slugExists = Event::where('slug', $slug)
                               ->whereNull('pandascore_id')
                               ->first();

            if ($slugExists) {
                $slugExists->update([
                    'pandascore_id' => (string) $t['id'],
                    'game_id'       => $game?->id ?? $slugExists->game_id,
                    'status'        => $this->mapStatus($t),
                    'approval_status' => 'approved',
                ]);
                $count++;
                continue;
            }

            Event::updateOrCreate(
                ['pandascore_id' => (string) $t['id']],
                [
                    'name'       => $t['name'],
                    'slug'       => $slug,
                    'game_id'    => $game?->id ?? null,
                    'user_id'    => 1,
                    'start_date' => isset($t['begin_at']) ? date('Y-m-d', strtotime($t['begin_at'])) : null,
                    'end_date'   => isset($t['end_at']) ? date('Y-m-d', strtotime($t['end_at'])) : null,
                    'prize_pool' => $t['prizepool'] ?? null,
                    'status'     => $this->mapStatus($t),
                    'approval_status' => 'approved',
                ]
            );
            $count++;
        }

        $this->info("  {$count} tournaments synced");
    }

    private function syncMatches(PandaScoreService $service): void
    {
        $this->line('-> Syncing matches...');

        $allMatches = [];

        try {
            $allMatches = array_merge($allMatches, $service->getLiveMatches());
        } catch (\Exception $e) {
            $this->warn('  Live matches timed out, skipping...');
        }

        try {
            $allMatches = array_merge($allMatches, $service->getUpcomingMatches());
        } catch (\Exception $e) {
            $this->warn('  Upcoming matches timed out, skipping...');
        }

        try {
            $allMatches = array_merge($allMatches, $service->getPastMatches());
        } catch (\Exception $e) {
            $this->warn('  Past matches timed out, skipping. Run sync again later.');
        }

        $count = 0;

        foreach ($allMatches as $m) {
            $teamA = isset($m['opponents'][0]['opponent']['id'])
                ? Team::where('pandascore_id', (string) $m['opponents'][0]['opponent']['id'])->first()
                : null;

            $teamB = isset($m['opponents'][1]['opponent']['id'])
                ? Team::where('pandascore_id', (string) $m['opponents'][1]['opponent']['id'])->first()
                : null;

            $event = isset($m['tournament_id'])
                ? Event::where('pandascore_id', (string) $m['tournament_id'])->first()
                : null;

            if (!$teamA || !$teamB || !$event) continue;

            $status = match($m['status'] ?? 'not_started') {
                'running'  => 'live',
                'finished' => 'completed',
                default    => 'upcoming',
            };

            $match = Matches::updateOrCreate(
                ['pandascore_id' => (string) $m['id']],
                [
                    'event_id'     => $event->id,
                    'team_a_id'    => $teamA->id,
                    'team_b_id'    => $teamB->id,
                    'scheduled_at' => $m['scheduled_at'] ?? null,
                    'status'       => $status,
                    'stage'        => $m['name'] ?? null,
                ]
            );

            // Save result if match is completed
            if ($status === 'completed') {
                $winnerId = null;
                if (isset($m['winner']['id'])) {
                    $winnerTeam = Team::where('pandascore_id', (string) $m['winner']['id'])->first();
                    $winnerId   = $winnerTeam?->id;
                }

                $scoreA = null;
                $scoreB = null;
                if (isset($m['results']) && count($m['results']) >= 2) {
                    foreach ($m['results'] as $result) {
                        if (isset($result['team_id'])) {
                            $resultTeam = Team::where('pandascore_id', (string) $result['team_id'])->first();
                            if ($resultTeam?->id === $teamA->id) {
                                $scoreA = $result['score'] ?? null;
                            } elseif ($resultTeam?->id === $teamB->id) {
                                $scoreB = $result['score'] ?? null;
                            }
                        }
                    }
                }

                Result::updateOrCreate(
                    ['match_id' => $match->id],
                    [
                        'winner_team_id' => $winnerId,
                        'score_a'        => $scoreA,
                        'score_b'        => $scoreB,
                    ]
                );
            }

            $count++;
        }

        $this->info("  {$count} matches synced");
    }

    private function mapStatus(array $tournament): string
    {
        $now   = now();
        $begin = isset($tournament['begin_at']) ? \Carbon\Carbon::parse($tournament['begin_at']) : null;
        $end   = isset($tournament['end_at'])   ? \Carbon\Carbon::parse($tournament['end_at'])   : null;

        if ($end && $now->greaterThan($end)) return 'completed';
        if ($begin && $now->lessThan($begin)) return 'upcoming';
        return 'live';
    }
}