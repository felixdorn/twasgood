<?php

namespace Database\Factories;

use App\Enums\IngredientType;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition(): array
    {
        return [
            // country > lorem ipsum
            'name' => $this->faker->country().' '.$this->faker->buildingNumber,
            'type' => $this->faker->randomElement(IngredientType::cases()),
            'contains_gluten' => $this->faker->boolean(),
            'contains_dairy' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
