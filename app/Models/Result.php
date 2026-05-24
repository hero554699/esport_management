<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'match_id',
        'winner_team_id',
        'score_a',
        'score_b',
        'mvp_player',
        'notes'
    ];

    public function match()
    {
        return $this->belongsTo(Matches::class);
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    public function mvp()
    {
        return $this->belongsTo(Player::class, 'mvp_player');
    }
}
