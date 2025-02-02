<?php

use App\Actions\SearchRecipes;
use App\Http\Controllers\Console\AssetsController;
use App\Http\Controllers\Console\CategoriesController;
use App\Http\Controllers\Console\IngredientsController;
use App\Http\Controllers\Console\RecipesController;
use App\Http\Controllers\Console\RecipesPrerequisiteController;
use App\Http\Controllers\Console\SectionsController;
use App\Http\Controllers\Console\ToggleTagController;
use App\Http\Controllers\OrderSectionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowCategoryController;
use App\Http\Controllers\ShowRecipeController;
use App\Http\Controllers\ShowSearchResultsController;
use App\Http\Controllers\ShowWelcomeController;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

Route::get('/', ShowWelcomeController::class)->name('welcome');
Route::get('/categories/{category}', ShowCategoryController::class)->name('categories.show');
Route::get('/recettes/{recipe}', ShowRecipeController::class)->name('recipes.show');
Route::get('/search', ShowSearchResultsController::class)->name('search');
Route::get('/guides/comment-steriliser-ses-bocaux', function () {
    $author = User::where('name', 'Charlotte Dorn')->first();

    return view('frontend.articles.sterilization', compact('author'));
})->name('sterilization-warning');
Route::view('/a-propos', 'frontend.about')->name('about-us');

Route::prefix('/partials')->group(function () {
    Route::get('/preview-search-results', function (Request $request) {
        $request->validate([
            'query' => ['nullable', 'string', 'max:1024'],
        ]);

        // DO THE QUERY STRING THING
        $query = $request->get('query');
        $recipes = (new SearchRecipes())($query);

        return view('partials.search-results', compact('query', 'recipes'));
    })->name('partials.preview-search-results');
});

Route::name('console.')->prefix('/console')->middleware(['auth'])->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // recipes
    Route::resource('recipes', RecipesController::class)->except(['show']);
    Route::get('/recipes/{recipe}/delete', [RecipesController::class, 'delete'])->name('recipes.delete');
    Route::post('/recipes/{recipe}/publish', [RecipesController::class, 'publish'])->name('recipes.publish');

    // recipe's prerequisites
    Route::post('/recipes/{recipe}/{prerequisiteType}/{prerequisite}', [RecipesPrerequisiteController::class, 'store'])->name('recipes.prerequisite.store');
    Route::put('/recipes/prerequisites/{prerequisite}', [RecipesPrerequisiteController::class, 'update'])->name('recipes.prerequisite.update');
    Route::delete('/recipes/prerequisites/{prerequisite}', [RecipesPrerequisiteController::class, 'destroy'])->name('recipes.prerequisite.destroy');
    Route::put('/recipes/{recipe}/prerequisites/order', [RecipesPrerequisiteController::class, 'order'])->name('recipes.prerequisite.order');

    // recipe's tags
    Route::post('/recipes/tags/{recipe}/toggle/{tag}', ToggleTagController::class)->name('recipes.tags.toggle');

    // ingredients
    Route::resource('ingredients', IngredientsController::class)->except(['show', 'delete']);

    // categories
    Route::resource('categories', CategoriesController::class)->except(['show', 'delete']);

    // sections
    Route::resource('sections', SectionsController::class)->except(['show', 'delete', 'edit']);
    Route::post('/sections/{section}/attach', [SectionsController::class, 'attach'])->name('sections.attach');
    Route::post('/sections/{section}/detach/{recipe}', [SectionsController::class, 'detach'])->name('sections.detach');
    Route::post('/sections/{section}/order', [SectionsController::class, 'order'])->name('sections.order');
    Route::post('/sections/{section}/toggle', [SectionsController::class, 'toggle'])->name('sections.toggle');
    Route::post('/order-sections', OrderSectionsController::class)->name('order-sections');

    // assets
    Route::post('/assets/upload', [AssetsController::class, 'upload'])->name('assets.upload');
    Route::patch('/assets/order', [AssetsController::class, 'order'])->name('assets.order');
    Route::delete('/assets/{asset}', [AssetsController::class, 'destroy'])->name('assets.destroy');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('authentik')->redirect();
})->name('auth.redirect');

Route::view('auth/error', 'auth.error')->name('auth.error');

Route::get('/auth/callback', function () {
    try {
        $authentikUser = Socialite::driver('authentik')->user();
    } catch (InvalidStateException|ClientException $e) {
        return to_route('auth.error');
    }

    $user = User::updateOrCreate([
        'authentik_id' => $authentikUser->id
    ], [
            'name' => $authentikUser->name,
            'email' => $authentikUser->email,
            'authentik_token' => $authentikUser->token,
            'authentik_refresh_token' => $authentikUser->refresh_token,
        ]);

    return to_route('console.recipes.index');
});


// legacy routes
Route::get('/categories-{category}', function ($category) {
    return to_route('categories.show', ['category' => $category], status: 301);
});
Route::get('/{category}-{recipe}', function ($category, $recipe) {
    return to_route('recipes.show', ['recipe' => $recipe], status: 301);
});
