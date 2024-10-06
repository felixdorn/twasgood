<?php

namespace App\Http\Controllers;

use App\Enums\RecipeComputedCategories;
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

        $keys = collect(RecipeComputedCategories::cases())->map(fn ($category) => $category->value)->filter(fn ($key) => $request->has($key))->values()->toArray();

        $recipes = Recipe::where('category_id', $category->id)
            ->whereNotNull('published_at')
            ->with([
                'prerequisites' => fn ($query) => $query->with('prerequisite'),
                'seasons',
                'tags',
                'slug',
                'banner' => fn ($query) => $query->select(['assets.id', 'thumbnail_path', 'alt']),
            ])
            ->where(function ($builder) use ($keys) {
                foreach (RecipeComputedCategories::cases() as $computedCategory) {
                    if ($computedCategory->shouldFilter($keys)) {
                        $builder->whereRaw('computed_categories & ? = ?', [1 << $computedCategory->position(), $computedCategory->shouldHaveIt() ? 1 << $computedCategory->position() : 0]);
                    }
                }
            })
            ->get(['id', 'title', 'description', 'computed_categories']);

        $recipes->each(function ($recipe) use ($orderedSeason) {
            $recipe->seasons = $recipe->seasons->sortBy(fn ($season) => $orderedSeason[Season::tryFrom($season->name)->name]);
            try {
                $recipe->closest_season = Season::tryFrom($recipe->seasons->first()->name)->name;
            } catch (\Throwable $th) {
                report($th);
                // todo: do not allow recipes without a seasonx
                $recipe->closest_season = Season::All->name;
            }
        });

        $recipes = $recipes->sortBy(fn ($recipe) => $orderedSeason[$recipe->closest_season])->values();

        $durationInMilliseconds = sprintf('%.2f', (microtime(true) - $start) * 1000);

        $category->load('slug')->setRelation('recipes', $recipes);

        return inertia('Marketing/Category/Show', [
            'category' => $category,
            'filters' => collect(RecipeComputedCategories::cases())
                ->filter(fn ($subCategory) => (bool) ($category->computed_available_subcategories->value & 1 << $subCategory->position()))
                ->map(fn (RecipeComputedCategories $subCategory) => [
                    'label' => $subCategory->label(),
                    'value' => $subCategory->value,
                    'active' => $subCategory->shouldFilter($keys),
                ]),
            'duration' => $durationInMilliseconds,
        ]);
    }
}
