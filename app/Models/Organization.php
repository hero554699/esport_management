<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'slug', 'logo_url', 'country', 'website'];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}