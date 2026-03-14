<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category',
    ];

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function scopeSolo($query)
    {
        return $query->where('type', 'solo');
    }

    public function scopeTeam($query)
    {
        return $query->where('type', 'team');
    }
}
