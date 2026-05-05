<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'pandascore_id',
        'name',
        'slug',
        'platform',
        'logo_url',
        'is_active'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
