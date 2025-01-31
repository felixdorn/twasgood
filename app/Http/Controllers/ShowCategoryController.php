<?php

namespace App\Http\Controllers;

use App\Enums\RecipeLabel;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Meilisearch\Client;

class ShowCategoryController
{
    public function __invoke(Request $request, Category $category, Client $meilisearch)
    {
        $has = [];
        $hasNot = [];

        if ($request->query->has('must_be_vegan')) {
            $has[] = RecipeLabel::IsVegan;
            ;
        }

        if ($request->query->has('at_least_vegetarian')) {
            $has[] = RecipeLabel::IsVegan;
            $has[] = RecipeLabel::IsVegetarian;
        }

        if ($request->query->has('no_gluten')) {
            $hasNot[] = RecipeLabel::ContainsGluten;
        }

        if ($request->query->has('no_dairy')) {
            $hasNot[] = RecipeLabel::ContainsDairy;
        }

        $filter = 'category_id = ' . $category->id;

        if (count($has) > 0) {
            $filter .= sprintf(
                ' AND labels IN [%s]',
                implode(', ', array_map(fn (RecipeLabel $label) => $label->value, $has))
            );
        }

        if (count($hasNot) > 0) {
            $filter .= sprintf(
                ' AND labels NOT IN [%s]',
                implode(', ', array_map(fn (RecipeLabel $label) => $label->value, $hasNot))
            );
        }

        $results = $meilisearch->index('recipes')->search('', [
            'filter' => $filter,
            'facets' => ['labels'],
            'limit' => 500
        ]);

        $ids = Arr::pluck($results->getHits(), 'id');
        $recipes = Recipe::whereIn('id', $ids)->with(['banner', 'slug'])->get();

        $relevantFacets = collect($results->getFacetDistribution()['labels'])
            ->filter(function ($_, $k) {
                return match (RecipeLabel::from($k)) {
                    RecipeLabel::IsVegetarian, RecipeLabel::IsVegan, RecipeLabel::ContainsDairy, RecipeLabel::ContainsGluten => true,
                    default => false
                };
            })
            ->map(function ($v, $k) {
                return [
                    'type' => RecipeLabel::from($k),
                    'count' => $v
                ];
            });

        return view('frontend.categories.show', [
            'category' => $category,
            'searchResults' => $recipes,
            'relevantFacets' => $relevantFacets,
        ]);
    }
}
