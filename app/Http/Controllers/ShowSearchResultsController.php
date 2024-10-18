<?php

namespace App\Http\Controllers;

use App\Actions\SearchRecipes;
use Illuminate\Http\Request;

class ShowSearchResultsController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'query' => ['nullable', 'string', 'max:1024']
        ]);

        $query = $request->get('query');

        if (empty($query)) {
            return to_route('welcome');
        }

        $recipes = (new SearchRecipes())($query);

        return view('search', compact('query', 'recipes'));
    }
}
