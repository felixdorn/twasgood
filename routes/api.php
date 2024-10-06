<?php

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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

Route::get('/search', function (Request $request) {
    $request->validate([
        'query' => ['nullable', 'string'],
        'limit' => ['integer', 'min:0', 'max:20'],
    ]);

    if (strlen($request->get('query')) === 0) {
        return [];
    }

    return Recipe::search($request->get('query'))
        ->query(fn (Builder $builder) => $builder->with(['slug', 'banner' => fn ($builder) => $builder->select('pixel_path', 'alt')])->select('id', 'title', 'description'))
        ->take($request->get('limit', 5))->get();
})->name('api.search');
