<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class RecipesController
{
    public function index(Request $request)
    {
        abort_unless(in_array($request->state, [null, 'published', 'unpublished']), 404);

        $state = $request->get('state', 'published');

        return view('backend.recipes.index', [
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
        return view('backend.recipes.create');
    }

    public function publish(Recipe $recipe)
    {
        if ($recipe->mustBeDraft()) {
            throw ValidationException::withMessages([
                'published_at' => 'La recette est incomplète et ne peut pas être publiée.',
            ]);
        }

        $recipe->publish();

        return Inertia::location(route('console.recipes.index', ['state' => 'published']));
    }

    public function delete(Recipe $recipe)
    {
        return view('backend.recipes.delete', ['recipe' => $recipe]);
    }

    public function destroy(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => ['required', 'string']
        ]);

        if (Str::slug($request->title) !== Str::slug($recipe->title)) {
            throw ValidationException::withMessages(['title' => 'Le titre de la recette ne correspond pas à celui dans notre base de données.']);
        }

        $recipe->delete();

        return Inertia::location(route('console.recipes.index', ['state' => $recipe->state]));
    }
}
