<?php

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/recipes/by-ids', function (Request $request) {
    $request->validate([
        // ids can be empty
        'ids' => ['array'],
        'ids.*' => ['required', 'integer', 'exists:recipes,id'],
    ]);

    if (empty($request->ids)) {
        return [];
    }

    return Recipe::select(['id', 'title', 'description'])->find($request->ids);
});

Route::get('/recipes', function (Request $request) {
    return Recipe::select(['id', 'title', 'description'])->get();
});
