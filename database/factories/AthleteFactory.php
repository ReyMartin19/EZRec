<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'     => $this->faker->name(),
            'age'      => $this->faker->numberBetween(16, 35),
            'team_id'  => Team::inRandomOrder()->first()?->id,
            'coach_id' => Coach::inRandomOrder()->first()?->id,
        ];
    }
}