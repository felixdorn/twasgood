<?php

namespace App\Http\Controllers\Console;

use App\Enums\PrerequisiteType;
use App\Models\Prerequisite;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecipesPrerequisiteController
{
    public function store(Request $request, Recipe $recipe, PrerequisiteType $prerequisiteType, string $prerequisite): RedirectResponse
    {
        $data = $request->validate([
            'details' => ['nullable', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'optional' => ['nullable', 'boolean'],
            'id' => ['required', match ($prerequisiteType) {
                PrerequisiteType::Ingredient => 'exists:ingredients,id',
                PrerequisiteType::Recipe => 'exists:recipes,id',
            }],
        ]);

        Prerequisite::create([
            'recipe_id' => $recipe->id,
            'prerequisite_id' => $prerequisite,
            'prerequisite_type' => $prerequisiteType->value,
            'details' => $data['details'],
            'quantity' => $data['quantity'],
            'optional' => $data['optional'] ?? false,
            'order' => $recipe->prerequisites()->count() + 1,
        ]);

        return to_route('console.recipes.edit', $recipe->id);
    }

    public function destroy(Prerequisite $prerequisite): RedirectResponse
    {
        $prerequisite->delete();

        return back();
    }

    public function order(Request $request, Recipe $recipe): RedirectResponse
    {
        $prerequisites = $request->validate([
            'prerequisites' => ['required', 'array', 'exists:prerequisites,id'],
        ]);

        $recipe->load('prerequisites');

        foreach ($prerequisites['prerequisites'] as $k => $prerequisite) {
            $recipe->prerequisites->where('id', $prerequisite)->first->update([
                'order' => $k,
            ]);
        }

        return back();
    }

    public function update(Prerequisite $prerequisite): ?Prerequisite
    {
        $data = request()->validate([
            'details' => ['nullable', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'optional' => ['nullable', 'boolean'],
        ]);

        $prerequisite->update([
            'details' => $data['details'],
            'quantity' => $data['quantity'],
            'optional' => $data['optional'] ?? false,
        ]);

        return $prerequisite->fresh();
    }
}
