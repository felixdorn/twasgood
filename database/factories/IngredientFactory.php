<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(30),
            'type' => fake()->randomElement(['vegan', 'vegetarian', 'meat']),
            'contains_gluten' => fake()->boolean(0.12),
            'contains_dairy' => fake()->boolean(0.03),
        ];
    }
}
