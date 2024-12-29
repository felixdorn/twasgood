<?php

namespace App\Http\Controllers\Console;

use App\Enums\IngredientType;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class IngredientsController
{
    public function index(Request $request)
    {
        $request->validate([
            'state' => ['nullable', new Enum(IngredientType::class)],
        ]);
        $state = $request->get('state') ?? IngredientType::Vegan->value;

        return view('backend.ingredients.index', [
            'state' => $state,
            'ingredients' => Ingredient::query()
                ->where('type', $state)
                ->latest('updated_at')
                ->get(),
        ]);
    }

    public function edit(Ingredient $ingredient)
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

    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::create(array_merge($request->validated(), [
            'contains_gluten' => $request->get('contains_gluten') === 'on',
            'contains_dairy' => $request->get('contains_dairy') === 'on'
        ]));

        return to_route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }

    public function create()
    {
        return view('backend.ingredients.create');
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->update(array_merge($request->validated(), [
            'contains_gluten' => $request->get('contains_gluten') === 'on',
            'contains_dairy' => $request->get('contains_dairy') === 'on'
        ]));

        return to_route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }

    public function transfer(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'recipe_id' => ['required', 'exists:recipes,id'],
        ]);

        $transfer = Recipe::find($request->get('recipe_id'));

        $ingredient->recipes()->each(function (Recipe $recipe) use ($transfer, $ingredient) {
            $old = $recipe->ingredients()->find($ingredient->id);

            $recipe->subRecipes()->attach($transfer->id, [
                'quantity' => $old->pivot->quantity,
                'details' => $old->pivot->details,
            ]);

            $recipe->ingredients()->detach($ingredient->id);
        });

        $ingredient->delete();

        return to_route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return route('console.ingredients.index', ['state' => $ingredient->type->value]);
    }
}
