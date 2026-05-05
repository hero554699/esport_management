<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'pandascore_id',
        'user_id',
        'game_id',
        'organization_id',
        'name',
        'slug',
        'acronym',
        'tag',
        'logo_url',
        'country',
        'location'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function matchesAsTeamA()
    {
        return $this->hasMany(Matches::class, 'team_a_id');
    }

    public function matchesAsTeamB()
    {
        return $this->hasMany(Matches::class, 'team_b_id');
    }
}
