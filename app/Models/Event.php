<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category',
        'team_id',
        'coach_id',
        'athlete_id',
    ];

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
