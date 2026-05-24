<?php

namespace App\Policies;

use App\Models\Matches;
use App\Models\Result;
use App\Models\User;

class ResultPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function viewAny(User $user, Matches $match): bool
    {
        return $match->event?->user_id === $user->id;
    }

    public function view(User $user, Result $result): bool
    {
        return $result->match?->event?->user_id === $user->id;
    }

    public function create(User $user, Matches $match): bool
    {
        return $match->event?->user_id === $user->id;
    }

    public function update(User $user, Result $result): bool
    {
        return $result->match?->event?->user_id === $user->id;
    }

    public function delete(User $user, Result $result): bool
    {
        return $result->match?->event?->user_id === $user->id;
    }
}
