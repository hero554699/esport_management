<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Matches;
use App\Models\User;

class MatchPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function viewAny(User $user, Event $event): bool
    {
        return $event->user_id === $user->id;
    }

    public function view(User $user, Matches $match): bool
    {
        return $match->event?->user_id === $user->id;
    }

    public function create(User $user, Event $event): bool
    {
        return $event->user_id === $user->id;
    }

    public function update(User $user, Matches $match): bool
    {
        return $match->event?->user_id === $user->id;
    }

    public function delete(User $user, Matches $match): bool
    {
        return $match->event?->user_id === $user->id;
    }
}
