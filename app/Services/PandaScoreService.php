<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PandaScoreService
{
    protected string $baseUrl = 'https://api.pandascore.co';
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.pandascore.token');
    }

    protected function get(string $endpoint, array $params = []): array
    {
        $response = Http::withToken($this->token)
            ->timeout(60)
            ->get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->failed()) {
            Log::error("PandaScore API error: {$endpoint}", [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return [];
        }

        return $response->json() ?? [];
    }

    public function getGames(): array
    {
        return $this->get('videogames', [
            'per_page' => 100,
        ]);
    }

    public function getTeams(int $page = 1): array
    {
        return $this->get('teams', [
            'per_page' => 100,
            'page'     => $page,
            'sort'     => '-modified_at',
        ]);
    }

    public function getPlayers(int $page = 1): array
    {
        return $this->get('players', [
            'per_page' => 100,
            'page'     => $page,
            'sort'     => '-modified_at',
        ]);
    }

    public function getLiveTournaments(): array
    {
        return $this->get('tournaments/running', [
            'per_page' => 100,
        ]);
    }

    public function getUpcomingTournaments(): array
    {
        return $this->get('tournaments/upcoming', [
            'per_page' => 100,
            'sort'     => 'begin_at',
        ]);
    }

    public function getPastTournaments(): array
    {
        return $this->get('tournaments/past', [
            'per_page' => 100,
            'sort'     => '-begin_at',
        ]);
    }

    public function getLiveMatches(): array
    {
        return $this->get('matches/running', [
            'per_page' => 100,
        ]);
    }

    public function getUpcomingMatches(): array
    {
        return $this->get('matches/upcoming', [
            'per_page' => 100,
            'sort'     => 'scheduled_at',
        ]);
    }

    public function getPastMatches(): array
    {
        return $this->get('matches/past', [
            'per_page' => 50,
            'sort'     => '-scheduled_at',
            'range[scheduled_at]' => now()->subDays(30)->format('Y-m-d') . ',' . now()->format('Y-m-d'),
        ]);
    }

    public function getMatch(int $id): array
    {
        return $this->get("matches/{$id}");
    }

    public function getTournament(int $id): array
    {
        return $this->get("tournaments/{$id}");
    }

    public function getMatchesByTournament(int $tournamentId): array
    {
        return $this->get("tournaments/{$tournamentId}/matches", [
            'per_page' => 100,
            'sort'     => 'scheduled_at',
        ]);
    }
}