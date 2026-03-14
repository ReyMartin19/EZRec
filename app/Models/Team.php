<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
    ];

    public function athletes()
    {
        return $this->hasMany(Athlete::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
