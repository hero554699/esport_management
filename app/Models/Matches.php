<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'pandascore_id',
        'event_id',
        'team_a_id',
        'team_b_id',
        'stage',
        'status',
        'scheduled_at'
    ];

    protected function casts(): array
    {
        return ['scheduled_at' => 'datetime'];
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function result()
    {
        return $this->hasOne(Result::class, 'match_id');
    }
}
