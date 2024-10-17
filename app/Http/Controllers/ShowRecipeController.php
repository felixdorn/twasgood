<?php

namespace App\Http\Controllers;

use App\Models\Prerequisite;
use App\Models\Recipe;

class ShowRecipeController
{
    public function __invoke(Recipe $recipe)
    {
        $prerequisites = Prerequisite::query()
            ->where('recipe_id', $recipe->id)
            ->with('prerequisite')
            ->select(['id', 'details', 'quantity', 'optional', 'prerequisite_id', 'prerequisite_type', 'recipe_id', 'order'])
            ->orderBy('order', 'asc')
            ->get()
            ->append(['display_mode']);

        $recipe->setRelation('prerequisites', $prerequisites);

        return view('recipes.show', [
            'recipe' => $recipe->load([
                'category',
                'banner' => fn ($query) => $query->select(['assets.id', 'path', 'alt']),
                'illustrations' => fn ($query) => $query->select(['assets.id', 'path', 'alt', 'resource_id', 'resource_type', 'order'])->orderBy('order', 'asc'),
            ]),
        ]);
    }
}
