<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'pandascore_id',
        'game_id',
        'user_id',
        'team_a_id',
        'team_b_id',
        'name',
        'slug',
        'status',
        'type',
        'start_date',
        'end_date',
        'prize_pool',
        'banner_url',
        'approval_status',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function matches()
    {
        return $this->hasMany(Matches::class);
    }
}
