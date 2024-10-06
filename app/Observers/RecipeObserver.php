<?php

namespace App\Observers;

use App\Jobs\ComputeSubcategoriesJob;
use App\Models\Recipe;

class RecipeObserver
{
    public function created(Recipe $recipe): void
    {
        ComputeSubcategoriesJob::dispatch($recipe->category);
    }

    public function updated(Recipe $recipe): void
    {
        ComputeSubcategoriesJob::dispatch($recipe->category);
    }
}
