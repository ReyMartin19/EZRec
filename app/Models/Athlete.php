<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    protected $fillable = [
        'name',
        'age',
        'coach_id',
        'team_id',
        'event_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}