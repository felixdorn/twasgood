<?php

namespace App\Http\Controllers;

use App\Actions\SearchRecipes;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Meilisearch\Client;

class ShowCategoryController
{
    public function __invoke(Request $request, Category $category, Client $meilisearch): View
    {
        $search = SearchRecipes::fromRequest($request)
            ->setCategory($category->id)
            ->run();

        return view('frontend.categories.show', [
            'category' => $category,
            'search' => $search,
            'recipes' => Recipe::query()
                ->with(['banner', 'slug'])
                ->whereIn('id', $search->ids())
                ->get(),
        ]);
    }
}
