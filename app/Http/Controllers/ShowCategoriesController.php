<?php

namespace App\Http\Controllers;

use App\Enums\Season;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ShowCategoriesController
{
    public function __invoke(Request $request, Category $category)
    {
        $orderedSeason = (Season::offsetFromCurrent());

        $start = microtime(true);

        $recipes = Recipe::where('category_id', $category->id)
            ->whereNotNull('published_at')
            ->with([
                'prerequisites' => fn ($query) => $query->with('prerequisite'),
                'seasons',
                'tags',
                'slug',
                'banner' => fn ($query) => $query->select(['assets.id', 'path', 'alt']),
            ])
            ->get(['id', 'title', 'description']);

        $recipes->each(function ($recipe) use ($orderedSeason) {
            $recipe->seasons = $recipe->seasons->sortBy(fn ($season) => $orderedSeason[Season::tryFrom($season->name)->name]);
            try {
                $recipe->closest_season = Season::tryFrom($recipe->seasons->first()->name)->name;
            } catch (\Throwable $th) {
                report($th);
                // todo: do not allow recipes without a season
                $recipe->closest_season = Season::All->name;
            }
        });

        $recipes = $recipes->sortBy(fn ($recipe) => $orderedSeason[$recipe->closest_season])->values();

        $durationInMilliseconds = sprintf('%.2f', (microtime(true) - $start) * 1000);

        $category->load('slug')->setRelation('recipes', $recipes);

        return view('frontend.categories.show', [
            'category' => $category,
            'duration' => $durationInMilliseconds,
        ]);
    }
}
