<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'pandascore_id',
        'game_id',
        'user_id',
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

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function matches()
    {
        return $this->hasMany(Matches::class);
    }
}
