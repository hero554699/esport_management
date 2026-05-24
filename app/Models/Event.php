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
        'prize_pool',
        'banner_url',
        'certification_path',
        'is_certification_public',
        'approval_status',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'is_certification_public' => 'boolean',
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

    public function matches()
    {
        return $this->hasMany(Matches::class);
    }

    /**
     * Check if tournament requires certification
     */
    public function requiresCertification(): bool
    {
        return in_array($this->type, ['national', 'international', 'world']);
    }

    /**
     * Check if certification is visible
     */
    public function hasCertification(): bool
    {
        return !empty($this->certification_path);
    }
}
