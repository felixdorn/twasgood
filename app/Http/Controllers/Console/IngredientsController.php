<?php

namespace App\Http\Controllers\Console;

use App\Enums\IngredientType;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

use function inertia;

class IngredientsController
{
    public function index(Request $request)
    {
        $request->validate([
            'active' => ['nullable', new Enum(IngredientType::class)],
        ]);
        $active = $request->get('active') ?? IngredientType::Vegan;

        return inertia('Console/Ingredient/Index', [
            'ingredients' => Ingredient::query()
                ->where('type', $active)
                ->latest('updated_at')
                ->get(),
            'active_tab' => $active,
        ]);
    }

    public function edit(Ingredient $ingredient)
    {
        return inertia('Console/Ingredient/Edit', [
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
        $ingredient = Ingredient::create($request->validated());

        return to_route('console.ingredients.index', ['active' => $ingredient->type->value]);
    }

    public function create()
    {
        return inertia('Console/Ingredient/Create');
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->validated());

        return to_route('console.ingredients.index', ['active' => $ingredient->type->value]);
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

        return to_route('console.ingredients.index', ['active' => $ingredient->type->value]);
    }
}
