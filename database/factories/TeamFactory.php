<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                        'Stingers', 'Eagles', 'Tigers', 'Warriors', 
                        'Falcons', 'Panthers', 'Wolves', 'Sharks',
                        'Lions', 'Bears',
                      ]) . ' ' . $this->faker->numberBetween(1, 99),
        ];
    }
}