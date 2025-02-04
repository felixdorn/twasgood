<?php

use App\Http\Controllers\Console\CategoriesController;
use App\Http\Controllers\Console\IngredientsController;
use App\Http\Controllers\Console\RecipesController;
use App\Http\Controllers\Console\RecipesPrerequisiteController;
use App\Http\Controllers\Console\SectionsController;
use App\Http\Controllers\Console\ToggleTagController;
use App\Http\Controllers\OrderCategoriesController;
use App\Http\Controllers\OrderSectionsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ShowCategoryController;
use App\Http\Controllers\ShowRecipeController;
use App\Http\Controllers\ShowSearchResultsController;
use App\Http\Controllers\ShowWelcomeController;
use App\Http\Controllers\Console\UpdateProfileController;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

Route::get('/', ShowWelcomeController::class)->name('welcome');
Route::get('/categories/{category}', ShowCategoryController::class)->name('categories.show');
Route::get('/recettes/{recipe}', ShowRecipeController::class)->name('recipes.show');
Route::get('/search', ShowSearchResultsController::class)->name('search');
Route::get('/guides/comment-steriliser-ses-bocaux', function () {
    $author = User::first();

    return view('frontend.articles.sterilization', compact('author'));
})->name('sterilization-warning');
Route::get('/a-propos', function () {
    return view('frontend.about', [
        'author' => User::first()
    ]);
})->name('about-us');

Route::redirect('/console', '/console/recipes')->name('console');
Route::name('console.')->prefix('/console')->middleware(['auth'])->group(function () {

    Route::put('profile', UpdateProfileController::class)->name('profile.update');

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
    Route::post('/order-categories', OrderCategoriesController::class)->name('order-categories');

    // sections
    Route::resource('sections', SectionsController::class)->except(['index', 'show', 'delete', 'edit']);
    Route::post('/sections/{section}/attach', [SectionsController::class, 'attach'])->name('sections.attach');
    Route::post('/sections/{section}/detach/{recipe}', [SectionsController::class, 'detach'])->name('sections.detach');
    Route::post('/sections/{section}/order-recipes', [SectionsController::class, 'order'])->name('sections.order-recipes');
    Route::post('/sections/{section}/toggle', [SectionsController::class, 'toggle'])->name('sections.toggle');
    Route::post('/order-sections', OrderSectionsController::class)->name('order-sections');

    Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
});

Route::redirect('/login', '/auth/redirect')->name('login');
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
        'authentik_id' => $authentikUser->id,
    ], [
        'name' => $authentikUser->name,
        'email' => $authentikUser->email,
        'authentik_token' => $authentikUser->token,
        'authentik_refresh_token' => $authentikUser->refresh_token,
    ]);

    Auth::login($user, false);

    return to_route('console.recipes.index');
});

// legacy routes
Route::get('/categories-{category}', function ($category) {
    return to_route('categories.show', ['category' => $category], status: 301);
});
Route::get('/{category}-{recipe}', function ($category, $recipe) {
    return to_route('recipes.show', ['recipe' => $recipe], status: 301);
});
