<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class RecipesController
{
    public function index(Request $request)
    {
        abort_unless(in_array($request->state, [null, 'published', 'unpublished']), 404);

        $state = $request->get('state', 'published');

        return inertia('Console/Recipe/Index', [
            'recipes' => Recipe::query()
                ->with('banner')
                ->when($state === 'unpublished', fn ($query) => $query->where('published_at', null))
                ->when($state === 'published', fn ($query) => $query->where('published_at', '<>', null))
                ->orderBy('updated_at', 'desc')
                ->get(),
            'unpublished_count' => Recipe::where('published_at', null)->count(),
            'published_count' => Recipe::where('published_at', '<>', null)->count(),
            'state' => $state,
        ]);
    }

    public function store(StoreRecipeRequest $request)
    {
        $recipe = Recipe::emptyWith(
            $request->validated('title')
        );

        return to_route('console.recipes.edit', $recipe);
    }

    public function edit(Recipe $recipe)
    {
        $recipe
            ->load([
                'category',
                'tags',
                'illustrations',
                'banner',
                'slugs',
            ]);
        $prerequisites = $recipe
            ->prerequisites()
            ->with('prerequisite')
            ->orderBy('order')
            ->get();

        $recipe->setRelation('prerequisites', $prerequisites);

        return inertia('Console/Recipe/Edit', [
            'recipe' => $recipe,
            'typeTags' => Tag::recipeTypeGroup()->children()->get(['id', 'name']),
            'seasonTags' => Tag::seasonGroup()->children()->get(['id', 'name']),
            'recipes' => Recipe::all(['id', 'title']),
            'ingredients' => Ingredient::all(['id', 'name']),
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return $recipe;
    }

    public function create()
    {
        return view('console.recipes.create');
        //return Inertia::modal('Console/Recipe/Create')->baseRoute('console.recipes.index');
    }

    public function publish(Recipe $recipe)
    {
        if ($recipe->mustBeDraft()) {
            throw ValidationException::withMessages([
                'published_at' => 'La recette est incomplète et ne peut pas être publiée.',
            ]);
        }

        $recipe->publish();

        return to_route('console.recipes.index', ['state' => 'published']);
    }

    public function redirectToIndex(Model $model)
    {
        return to_route('console.recipes.index', ['state' => $model->state]);
    }
}
