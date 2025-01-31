<?php

namespace App\Http\Controllers\Console;

use App\Models\Recipe;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionsController
{
    public function index(Request $request): View
    {
        $focus = $request->get('focus');

        if (Section::find($focus) === null) {
            $focus = null;
        } else {
            $focus = (int) $focus;
        }

        $sections = Section::with('recipes')
            ->orderBy('order')
            ->get();

        return view('backend.sections.index', [
            'focus' => $focus,
            'visible_sections' => $sections->whereNull('hidden_at'),
            'hidden_sections' => $sections->whereNotNull('hidden_at'),
            'recipes' => Recipe::whereNotNull('published_at')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $section = Section::create(array_merge($data, [
            'hidden_at' => now()
        ]));

        return to_route('console.sections.index', ['focus' => $section->id]);
    }

    public function create(): View
    {
        return view('backend.sections.create');
    }

    public function attach(Request $request, Section $section): RedirectResponse
    {
        $request->validateWithBag('section-attach-'.$section->id, [
            'title' => ['required', 'string', 'exists:recipes,title'],
        ]);

        $recipe = Recipe::where('title', $request->title)->sole();

        $section->recipes()->attach($recipe);

        return to_route('console.sections.index', ['focus' => $section->id]);
    }

    public function detach(Section $section, Recipe $recipe): RedirectResponse
    {
        $section->recipes()->detach($recipe);

        // TODO: We should move this to flash, and use back() instead of to_route('...') for the others.
        return to_route('console.sections.index', ['focus' => $section->id]);
    }

    public function order(Request $request, Section $section): RedirectResponse
    {
        $request->validate([
            'items' => ['required', 'array', 'exists:recipes,id'],
        ]);

        // load section's recipes with pivot data
        $section->load('recipes');

        foreach ($request->items as $index => $recipeId) {
            $section->recipes()->updateExistingPivot($recipeId, ['order' => $index]);
        }

        return response(201);
    }

    public function update(Request $request, Section $section): RedirectResponse
    {
        $data = $request->validateWithBag('section-'.$section->id, [
            'title' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
        ]);

        $section->update($data);

        return to_route('console.sections.index');
    }

    public function toggle(Section $section): RedirectResponse
    {
        $section->update(['hidden_at' => $section->hidden_at === null ? now() : null]);

        return to_route('console.sections.index');
    }

    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return to_route('console.sections.index');
    }
}
