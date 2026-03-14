<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Coach;
use App\Models\Team;
use App\Models\Athlete;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1st — Create base data
        Event::factory(10)->create();
        Coach::factory(5)->create();
        Team::factory(6)->create();

        // 2nd — Create athletes (needs teams & coaches to exist first)
        $athletes = Athlete::factory(30)->create();

        // 3rd — Attach random events to each athlete via pivot
        $events = Event::all();

        $athletes->each(function ($athlete) use ($events) {
            // Each athlete joins 1 to 3 random events
            $randomEvents = $events->random(rand(1, 3))->pluck('id');
            $athlete->events()->attach($randomEvents);
        });
    }
}