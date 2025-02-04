<?php

namespace App\Actions;

use App\Enums\IngredientType;
use App\Models\Ingredient;
use App\Models\Recipe;
use Exception;

class LabelRecipes
{
    public function __invoke(Recipe $recipe): array
    {
        $recipe->load(['prerequisites' => fn ($q) => $q->where('optional', false)->with(['prerequisite'])]);

        $labels = [
            'isVegan' => true,
            'isVegetarian' => true,
            'containsGluten' => false,
            'containsDairy' => false,
        ];

        foreach ($recipe->prerequisites as $prerequisite) {
            switch ($prerequisite->prerequisite_type) {
                case 'recipe':
                    /** @var Recipe $subRecipe */
                    $subRecipe = $prerequisite->prerequisite;
                    $labels = $this->combineLabels($labels, (new self())($subRecipe));
                    break;
                case 'ingredient':
                    /** @var Ingredient $ingredient */
                    $ingredient = $prerequisite->prerequisite;

                    $other = [
                        'containsDairy' => $ingredient->contains_dairy,
                        'containsGluten' => $ingredient->contains_gluten,
                        'isVegan' => match ($ingredient->type) {
                            IngredientType::Vegan, IngredientType::Other => true,
                            IngredientType::Vegetarian, IngredientType::Meat => false
                        },
                        'isVegetarian' => match ($ingredient->type) {
                            IngredientType::Vegan, IngredientType::Vegetarian, IngredientType::Other => true,
                            IngredientType::Meat => false
                        },
                    ];

                    $labels = $this->combineLabels($labels, $other);
                    break;
                default:
                    throw new Exception('Unexpected prerequisite_type: '.$prerequisite->prerequisite_type);
            }
        }

        return $labels;
    }

    public function combineLabels(array $labels, array $other): array
    {
        $labels['containsGluten'] = $labels['containsGluten'] || $other['containsGluten'];
        $labels['containsDairy'] = $labels['containsDairy'] || $other['containsDairy'];
        $labels['isVegan'] = $labels['isVegan'] && $other['isVegan'];
        $labels['isVegetarian'] = $labels['isVegetarian'] && $other['isVegetarian'];

        return $labels;
    }
}
