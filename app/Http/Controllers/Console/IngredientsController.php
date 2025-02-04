<?php

namespace App\Http\Controllers\Console;

use App\Enums\IngredientType;
use App\Http\Requests\StoreIngredientRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class IngredientsController
{
    public function index(Request $request): View
    {
        $request->validate([
            'state' => ['nullable', new Enum(IngredientType::class)],
        ]);
        $state = $request->get('state') ?? IngredientType::Vegan->value;

        return view('backend.ingredients.index', [
            'state' => $state,
            'ingredients' => Ingredient::query()
                ->where('type', $state)
                ->orderBy('name')
                ->get()->groupBy(function ($ingredient) {
                    return $ingredient->name[0];
                }),
        ]);
    }

    public function edit(Ingredient $ingredient): View
    {
        return view('backend.ingredients.edit', [
            'ingredient' => $ingredient->load([
                'prerequisites' => fn ($query) => $query->with([
                    'recipe' => fn ($query) => $query->select(['id', 'title']),
                ]),
            ]),
            'usage_count' => $ingredient->prerequisites()->count(),
            'recipes' => Recipe::all(['id', 'title']),
        ]);
    }

    public function store(StoreIngredientRequest $request): RedirectResponse
    {
        $ingredient = Ingredient::create(array_merge($request->validated(), [
            'contains_gluten' => $request->get('contains_gluten') === 'on',
            'contains_dairy' => $request->get('contains_dairy') === 'on',
        ]));

        return to_route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }

    public function create(): View
    {
        return view('backend.ingredients.create');
    }

    public function update(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:ingredients,name,'.$ingredient->id],
            'type' => ['required', (new Enum(IngredientType::class))],
        ]);

        $ingredient->update(array_merge($data, [
            'contains_gluten' => $request->get('contains_gluten') === 'on',
            'contains_dairy' => $request->get('contains_dairy') === 'on',
        ]));

        return to_route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }

    public function destroy(Ingredient $ingredient): string
    {
        $ingredient->delete();

        return route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }
}
