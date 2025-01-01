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

        // TODO: Take hidden_at (if null but force_hide is true, set hidden_at to 1900 and update the section)
        $sections = Section::with(['recipes' => fn ($query) => $query->with('banner')])
            ->orderBy('order')
            ->get();

        return view('backend.sections.index', [
            'focus' => $focus,
            'visible_sections' => $sections->where('force_hide', false),
            'hidden_sections' => $sections->where('force_hide', true),
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
            'force_hide' => true,
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

        return redirect()->route('console.sections.index', ['focus' => $section->id]);
    }

    public function detach(Section $section, Recipe $recipe): RedirectResponse
    {
        $section->recipes()->detach($recipe);

        return redirect()->route('console.sections.index', ['focus' => $section->id]);
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

        return back();
    }

    public function update(Request $request, Section $section): RedirectResponse
    {
        $data = $request->validateWithBag('section-'.$section->id, [
            'title' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
        ]);

        $section->update($data);

        return back();
    }

    public function toggle(Section $section): RedirectResponse
    {
        $section->update(['force_hide' => ! $section->force_hide]);

        return back();
    }

    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return back();
    }
}
