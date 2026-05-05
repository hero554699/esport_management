<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'pandascore_id',
        'team_id',
        'nickname',
        'first_name',
        'last_name',
        'username',
        'real_name',
        'nationality',
        'country',
        'avatar_url',
        'role',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}