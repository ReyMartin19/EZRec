<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['solo', 'team']);

        return [
            'name'        => $this->faker->randomElement([
                                '100m Sprint', '200m Relay', 'Basketball', 
                                'Volleyball', 'Swimming', 'Long Jump', 
                                'Shot Put', 'Badminton', 'Table Tennis'
                            ]),
            'type'        => $type,
            'category'    => $this->faker->randomElement(['male', 'female', 'mixed']),
            'max_members' => $type === 'team' ? $this->faker->numberBetween(4, 12) : null,
        ];
    }
}