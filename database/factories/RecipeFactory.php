<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realTextBetween(20, 80),
            'description' => fake()->realTextBetween(60, 200),
            'time_to_prepare' => fake()->realTextBetween(5, 10),
            'uses_sterilization' => fake()->boolean(0.05),
            'content' => '{"type":"doc","content":[]}',
        ];
    }
}
