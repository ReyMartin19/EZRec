<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CoachFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'   => $this->faker->name(),
            'event'  => $this->faker->randomElement([
                            '100m Sprint', 'Basketball', 'Swimming', 'Volleyball'
                        ]),
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }
}