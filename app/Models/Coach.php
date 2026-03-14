<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = [
        'name',
        'event',
        'gender',
    ];

    public function athletes()
    {
        return $this->hasMany(Athlete::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
