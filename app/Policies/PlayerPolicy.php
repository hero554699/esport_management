<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;

class PlayerPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function viewAny(User $user, Team $team): bool
    {
        return $team->user_id === $user->id;
    }

    public function view(User $user, Player $player): bool
    {
        return $player->team?->user_id === $user->id;
    }

    public function create(User $user, Team $team): bool
    {
        return $team->user_id === $user->id;
    }

    public function update(User $user, Player $player): bool
    {
        return $player->team?->user_id === $user->id;
    }

    public function delete(User $user, Player $player): bool
    {
        return $player->team?->user_id === $user->id;
    }
}
