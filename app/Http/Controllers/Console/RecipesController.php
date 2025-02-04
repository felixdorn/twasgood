<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\TagGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RecipesController
{
    public function index(Request $request): View
    {
        abort_unless(in_array($request->state, [null, 'published', 'unpublished'], true), 404);

        $state = $request->get('state', 'published');

        return view('backend.recipes.index', [
            'recipes' => Recipe::query()
                ->when($state === 'unpublished', fn ($query) => $query->where('published_at', null))
                ->when($state === 'published', fn ($query) => $query->where('published_at', '<>', null))
                ->with('banner')
                ->orderBy('updated_at', 'desc')
                ->get(),
            'unpublished_count' => Recipe::where('published_at', null)->count(),
            'published_count' => Recipe::where('published_at', '<>', null)->count(),
            'state' => $state,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:recipes,title'],
        ]);

        $recipe = Recipe::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
        ]);

        return to_route('console.recipes.edit', $recipe);
    }

    public function edit(Recipe $recipe): View
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

        return view('backend.recipes.edit', [
            'recipe' => $recipe,
            'typeTags' => TagGroup::where('name', 'recipe_type')->sole()->tags()->get(['id', 'name']),
            'seasonTags' => TagGroup::where('name', 'seasons')->sole()->tags()->get(['id', 'name']),
            'recipes' => Recipe::all(['id', 'title']),
            'ingredients' => Ingredient::all(['id', 'name']),
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe): Recipe
    {
        $recipe->update($request->validated());

        return $recipe;
    }

    public function create(): View
    {
        return view('backend.recipes.create');
    }

    public function publish(Recipe $recipe): RedirectResponse
    {
        if ($recipe->mustBeDraft()) {
            throw ValidationException::withMessages([
                'published_at' => 'La recette est incomplète et ne peut pas être publiée.',
            ]);
        }

        $recipe->publish();

        return to_route('console.recipes.index', ['state' => 'published']);
    }

    public function delete(Recipe $recipe): View
    {
        return view('backend.recipes.delete', ['recipe' => $recipe]);
    }

    public function destroy(Request $request, Recipe $recipe): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string'],
        ]);

        if (Str::slug($request->title) !== Str::slug($recipe->title)) {
            throw ValidationException::withMessages(['title' => 'Le titre de la recette ne correspond pas à celui dans notre base de données.']);
        }

        $recipe->delete();

        return to_route('console.recipes.index');
    }
}
