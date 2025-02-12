<?php

namespace App\Http\Controllers;

use App\Actions\SearchRecipes;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShowSearchResultsController
{
    public function __invoke(Request $request): View
    {
        $search = SearchRecipes::fromRequest($request)->run();

        return view('frontend.search', [
            'search' => $search,
            'recipes' => Recipe::query()
                ->with(['banner', 'slug'])
                ->whereIn('id', $search->ids())
                ->get(),
        ]);
    }
}
