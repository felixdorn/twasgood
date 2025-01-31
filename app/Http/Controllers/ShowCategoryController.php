<?php

namespace App\Http\Controllers;

use App\Enums\RecipeLabel;
use App\Enums\RecipeType;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;
use Meilisearch\Client;

class ShowCategoryController
{
    public function __invoke(Request $request, Category $category, Client $meilisearch)
    {
        $data = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'has' => ['nullable', 'array'],
            'has.*' => [(new Enum(RecipeLabel::class))->only([RecipeLabel::IsVegan, RecipeLabel::IsVegetarian])],
            'has_not' => ['nullable', 'array'],
            'has_not.*' => [(new Enum(RecipeLabel::class))->only([RecipeLabel::ContainsDairy, RecipeLabel::ContainsGluten])],
            'occasion' => [new Enum(RecipeType::class)]
        ]);


        $query = $data['q'] ?? '';
        $hasLabel = $data['has'] ?? [];
        $hasNotLabel = $data['has_not'] ?? [];
        $occasion = $data['occasion'] ?? null;

        $filter = 'category_id = ' . $category->id;

        if (count($hasLabel) > 0) {
            foreach ($hasLabel as $label) {
                $filter .= sprintf(' AND labels IN [%s]', $label);
            }
        }

        if ($occasion !== null && $occasion !== RecipeType::ForAllOccasions->value) {
            $label = (match(RecipeType::from($occasion)) {
                RecipeType::Apero => RecipeLabel::ForApero,
                RecipeType::Snack => RecipeLabel::ForSnack,
                RecipeType::Starter => RecipeLabel::ForStarter,
                RecipeType::Dish => RecipeLabel::ForDish,
                RecipeType::Desert => RecipeLabel::ForDesert,
            })->value;

            $filter .= sprintf(' AND labels IN [%s]', $label);
        }


        if (count($hasNotLabel) > 0) {
            foreach ($hasNotLabel as $label) {
                $filter .= sprintf(' AND labels NOT IN [%s]', $label);
            }
        }

        $results = $meilisearch->index('recipes')->search($query, [
            'filter' => $filter,
            'facets' => ['labels'],
            'attributesToRetrieve' => ['id', 'labels'],
            'locales' => ['fr'],
            'limit' => 1000  // TODO: Pagination?
        ]);

        //dd($results, $hasLabel);

        $rawFacets = $results->getFacetDistribution()['labels'];
        $facets = [
            ['op' => 'has_not', 'label' => RecipeLabel::ContainsDairy],
            ['op' => 'has_not', 'label' => RecipeLabel::ContainsGluten],
            ['op' => 'has', 'label' => RecipeLabel::IsVegetarian],
            ['op' => 'has', 'label' => RecipeLabel::IsVegan],
        ];
        foreach ($facets as $k => $facet) {
            ['op' => $op, 'label' => $label] = $facet;

            $facets[$k]['active'] = in_array($label->value, $op === 'has' ? $hasLabel : $hasNotLabel, true);
            $facets[$k]['count'] = array_key_exists($label->value, $rawFacets) ? $rawFacets[$label->value] : 0;
        }

        $facets = array_filter($facets, fn (array $facet) => $facet['active'] === true || ($facet['count'] > 0 && $facet['count'] < $results->getHitsCount()));

        return view('frontend.categories.show', [
            'category' => $category,
                'searchResults' => Recipe::query()
                    ->with(['banner', 'slug'])
                    ->whereIn('id', Arr::pluck($results->getHits(), 'id'))
                    ->get(),
                'query' => $query,
                'occasion' => $occasion,
                'facets' => $facets,
                'estimatedTotal' => $results->getEstimatedTotalHits()
            ]);
    }
}
