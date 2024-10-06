<?php

namespace App\Jobs;

use App\Enums\IngredientType;
use App\Enums\PrerequisiteType;
use App\Enums\RecipeComputedCategories;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\ComputedCategories;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeRecipeCategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Recipe $recipe) {}

    public function handle(): void
    {
        $this->recipe->load([
            'prerequisites' => fn ($query) => $query->with('prerequisite'),
        ]);

        $properties = new ComputedCategories;

        foreach ($this->recipe->prerequisites as $prerequisite) {
            if ($prerequisite->optional) {
                continue;
            }

            (match ($prerequisite->type) {
                PrerequisiteType::Recipe => fn (Recipe $recipe) => $properties->combine($recipe->computed_categories),
                PrerequisiteType::Ingredient => function (Ingredient $ingredient) use ($properties) {
                    $properties->toggleAndLockIf(
                        $ingredient->contains_dairy,
                        RecipeComputedCategories::ContainsDairy
                    );

                    $properties->toggleAndLockIf(
                        $ingredient->contains_gluten,
                        RecipeComputedCategories::ContainsGluten
                    );

                    $properties->toggleAndLockIf(
                        $ingredient->type === IngredientType::Meat,
                        RecipeComputedCategories::IsNotVegetarian,
                        RecipeComputedCategories::IsNotVegan
                    );

                    $properties->toggleAndLockIf(
                        ! in_array($ingredient->type, [IngredientType::Vegan, IngredientType::Other]),
                        RecipeComputedCategories::IsNotVegan
                    );
                }
            })($prerequisite->prerequisite);
        }

        foreach ($this->recipe->types as $type) {
            $properties->toggleAndLockIf(
                $type->name === 'Apéro',
                RecipeComputedCategories::IsPreDinnerDrink
            );

            $properties->toggleAndLockIf(
                $type->name === 'Goûter',
                RecipeComputedCategories::IsSnack
            );

            $properties->toggleAndLockIf(
                $type->name === 'Entrée',
                RecipeComputedCategories::IsStarter
            );

            $properties->toggleAndLockIf(
                $type->name === 'Plat',
                RecipeComputedCategories::IsDinner
            );

            $properties->toggleAndLockIf(
                $type->name === 'Dessert',
                RecipeComputedCategories::IsDessert
            );
        }

        $this->recipe->update(['computed_categories' => $properties]);
    }
}
