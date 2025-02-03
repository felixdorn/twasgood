<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prerequisite>
 */
class PrerequisiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => sprintf('%s %s', fake()->numberBetween(0, 1000), fake()->word()),
            'details' => fake()->randomElement(['(liquide)', '(rapé)']),
            'optional' => fake()->boolean(0.05),
        ];
    }
}
