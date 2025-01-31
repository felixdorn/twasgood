<?php

namespace App\Services\RecipeEnrichment;

use App\Enums\IngredientType;
use App\Models\Recipe;
use Exception;

class RecipeEnricher
{
    public static function enrich(Recipe $recipe): ComputedProperties
    {
        return (new self())->computeMetadataAboutPrerequisites($recipe);
    }

    public function computeMetadataAboutPrerequisites(Recipe $recipe): ComputedProperties
    {
        $props = new ComputedProperties();

        $recipe->load(['prerequisites' => fn ($q) => $q->with(['prerequisite'])]);

        foreach ($recipe->prerequisites as $prerequisite) {
            // TODO: Check for ambiguity.
            if ($prerequisite->optional) {
                continue;
            }


            if ($prerequisite->prerequisite_type === "recipe") {
                // TODO: There's optimisation to be done here.
                $props = $this->merge(
                    $props,
                    $this->computeMetadataAboutPrerequisites($prerequisite->prerequisite)
                );
            } elseif ($prerequisite->prerequisite_type === "ingredient") {
                $ingredient = $prerequisite->prerequisite;

                $other = new ComputedProperties(
                    containsDairy: $ingredient->contains_dairy,
                    containsGluten: $ingredient->contains_gluten,
                );

                $other->isVegan = match ($ingredient->type) {
                    IngredientType::Vegan, IngredientType::Other => true,
                    IngredientType::Vegetarian, IngredientType::Meat => false
                };

                $other->isVegetarian = match ($ingredient->type) {
                    IngredientType::Vegan, IngredientType::Vegetarian, IngredientType::Other => true,
                    IngredientType::Meat => false
                };

                $props = $this->merge($props, $other);
            } else {
                throw new Exception("Unexpected prerequisite_type: " . $prerequisite->prerequisite_type);
            }
        }

        return $props;
    }

    public function merge(ComputedProperties $props, ComputedProperties $other): ComputedProperties
    {
        $props->containsGluten = $props->containsGluten || $other->containsGluten;
        $props->containsDairy =  $props->containsDairy || $other->containsDairy;
        $props->isVegan = $props->isVegan &&  $other->isVegan;
        $props->isVegetarian = $props->isVegetarian && $other->isVegetarian;

        return $props;
    }
}
