<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'team_id',
        'coach_id',
        'athlete_id',
        'max_members',
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
