<?php

use App\Http\Controllers\Console\ArticlesController;
use App\Http\Controllers\Console\AssetsController;
use App\Http\Controllers\Console\CategoriesController;
use App\Http\Controllers\Console\DiagnosesController;
use App\Http\Controllers\Console\IngredientsController;
use App\Http\Controllers\Console\RecipesController;
use App\Http\Controllers\Console\RecipesPrerequisiteController;
use App\Http\Controllers\Console\SectionsController;
use App\Http\Controllers\Console\TasksController;
use App\Http\Controllers\Console\ToggleTagController;
use App\Http\Controllers\OrderSectionsController;
use App\Http\Controllers\ShowCategoriesController;
use App\Http\Controllers\ShowRecipeController;
use App\Http\Controllers\ShowWelcomeController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ShowWelcomeController::class)->name('welcome');

Route::get('/categories/{category}', ShowCategoriesController::class)->name('categories.show');

Route::get('/recettes/{recipe}', ShowRecipeController::class)->name('recipes.show');

Route::get('/guides/comment-steriliser-ces-bocaux', function () {
    return inertia('Marketing/Article/Sterilization');
})->name('sterilization-warning');

Route::get('/a-propos', function () {
    return inertia('Marketing/About');
})->name('about-us');

Route::prefix('/console')->middleware(['auth'])->group(function () {
    Route::redirect('/', '/console/recipes')->name('console.index');

    // recipes
    Route::name('console')->resource('recipes', RecipesController::class)->except(['show']);
    Route::post('/recipes/{recipe}/publish', [RecipesController::class, 'publish'])->name('console.recipes.publish');

    // recipe's prerequisites
    Route::post('/recipes/{recipe}/{prerequisiteType}/{prerequisite}', [RecipesPrerequisiteController::class, 'store'])->name('console.recipes.prerequisite.store');
    Route::get('/recipes/{recipe}/prerequisites/create', [RecipesPrerequisiteController::class, 'create'])->name('console.recipes.prerequisite.create');
    Route::get('/recipes/{recipe}/prerequisites/{prerequisite}/edit', [RecipesPrerequisiteController::class, 'edit'])->name('console.recipes.prerequisite.edit');
    Route::put('/recipes/prerequisites/{prerequisite}', [RecipesPrerequisiteController::class, 'update'])->name('console.recipes.prerequisite.update');
    Route::delete('/recipes/prerequisites/{prerequisite}', [RecipesPrerequisiteController::class, 'destroy'])->name('console.recipes.prerequisite.destroy');
    Route::put('/recipes/{recipe}/prerequisites/order', [RecipesPrerequisiteController::class, 'order'])->name('console.recipes.prerequisite.order');

    // recipe's tags
    Route::post('/recipes/tags/{recipe}/toggle/{tag}', ToggleTagController::class)->name('console.recipes.tags.toggle');

    // ingredients
    Route::name('console')->resource('ingredients', IngredientsController::class)->except(['show', 'delete']);

    // categories
    Route::name('console')->resource('categories', CategoriesController::class)->except(['show', 'delete']);

    // tasks
    Route::post('/tasks', [TasksController::class, 'store'])->name('console.tasks.store');
    Route::post('/tasks/{task}/complete', [TasksController::class, 'complete'])->name('console.tasks.complete');

    // diagnoses
    Route::get('/diagnoses', [DiagnosesController::class, 'index'])->name('console.diagnoses.index');
    Route::post('/diagnoses/{diagnosis}/complete', [DiagnosesController::class, 'complete'])->name('console.diagnoses.complete');

    Route::put('/order-sections', OrderSectionsController::class)->name('console.order-sections');

    // sections
    Route::get('/sections', [SectionsController::class, 'index'])->name('console.sections.index');
    Route::get('/sections/create', [SectionsController::class, 'create'])->name('console.sections.create');
    Route::post('/sections', [SectionsController::class, 'store'])->name('console.sections.store');
    Route::get('/sections/{section}/edit', [SectionsController::class, 'edit'])->name('console.sections.edit');
    Route::post('/sections/{section}', [SectionsController::class, 'update'])->name('console.sections.update');
    Route::post('/sections/{section}/attach', [SectionsController::class, 'attach'])->name('console.sections.attach');
    Route::post('/sections/{section}/detach/{recipe}', [SectionsController::class, 'detach'])->name('console.sections.detach');
    Route::post('/sections/{section}/order', [SectionsController::class, 'order'])->name('console.sections.order');
    Route::post('/sections/{section}/add-activation-period/{activationPeriodType}', [SectionsController::class, 'addActivationPeriod'])->name('console.sections.add-activation-period');
    Route::post('/sections/{section}/add-custom-date', [SectionsController::class, 'addCustomDate'])->name('console.sections.add-custom-date');
    Route::delete('/sections/remove-activation-period/{activationPeriod}', [SectionsController::class, 'removeActivationPeriod'])->name('console.sections.remove-activation-period');
    Route::post('/sections/{section}/associate-article/{article}', [SectionsController::class, 'associateArticle'])->name('console.sections.associate-article');
    Route::delete('/sections/{section}/dissociate-article', [SectionsController::class, 'dissociateArticle'])->name('console.sections.dissociate-article');

    // articles
    Route::get('/articles', [ArticlesController::class, 'index'])->name('console.articles.index');
    Route::get('/articles/create', [ArticlesController::class, 'create'])->name('console.articles.create');
    Route::post('/articles', [ArticlesController::class, 'store'])->name('console.articles.store');
    Route::get('/articles/{article}/edit', [ArticlesController::class, 'edit'])->name('console.articles.edit');
    Route::patch('/articles/{article}', [ArticlesController::class, 'update'])->name('console.articles.update');
    Route::post('/articles/{article}/publish', [ArticlesController::class, 'publish'])->name('console.articles.publish');

    // assets
    Route::post('/assets/upload', [AssetsController::class, 'upload'])->name('console.assets.upload');
    Route::patch('/assets/order', [AssetsController::class, 'order'])->name('console.assets.order');
    Route::delete('/assets/{asset}', [AssetsController::class, 'destroy'])->name('console.assets.destroy');
});

// legacy routes
Route::get('/categories-{category}', function ($category) {
    return to_route('categories.show', ['category' => $category], status: 301);
});
Route::get('/{category}-{recipe}', function ($category, $recipe) {
    return to_route('recipes.show', ['recipe' => $recipe], status: 301);
});

require __DIR__.'/auth.php';
