<?php

namespace App\Http\Controllers;

use App\Models\Prerequisite;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;

class ShowRecipeController
{
    public function __invoke(Recipe $recipe): View
    {
        $prerequisites = Prerequisite::query()
            ->where('recipe_id', $recipe->id)
            ->with('prerequisite')
            ->select(['id', 'details', 'quantity', 'optional', 'prerequisite_id', 'prerequisite_type', 'recipe_id', 'order'])
            ->orderBy('order', 'asc')
            ->get();

        $recipe->setRelation('prerequisites', $prerequisites);

        return view('frontend.recipes.show', [
            'recipe' => $recipe->load([
                'category',
                'illustrations',
                'author' => fn ($q) => $q->with('portrait'),
            ]),
        ]);
    }
}
