<?php

namespace App\Http\Controllers\Console;

use App\Models\Article;
use App\Models\Recipe;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionsController
{
    public function index(Request $request)
    {
        abort_unless(in_array($request->state, [null, 'visible', 'hidden']), 404);

        $state = $request->get('state', 'visible');

        // TODO: Take hidden_at (if null but force_hide is true, set hidden_at to 1900 and update the section)

        return view('backend.sections.index', [
            'sections' => Section::with([
                'recipes' => fn ($query) => $query->with('banner'),
            ])->orderBy('order')->get()->groupBy('force_hide')->sortKeys(),
            'state' => $state,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $section = Section::create(['title' => $request->title]);

        return to_route('console.sections.edit', ['section' => $section->id]);
    }

    public function create()
    {
        return view('backend.sections.create');
    }

    public function edit(Section $section)
    {
        $section->load('recipes', 'article');

        return \inertia('Console/Sections/Edit', [
            'section' => $section,
            'recipes' => Recipe::whereNotIn('id', $section->recipes->pluck('id'))->get(),
            'articles' => Article::where('published_at', '<>', null)->get(),
        ]);
    }

    public function attach(Request $request, Section $section)
    {
        $request->validate([
            'recipe' => ['required', 'exists:recipes,id'],
        ]);

        $section->recipes()->attach($request->recipe);

        return back();
    }

    public function detach(Section $section, Recipe $recipe)
    {
        $section->recipes()->detach($recipe);

        return back();
    }

    public function order(Request $request, Section $section)
    {
        $request->validate([
            'recipes' => ['required', 'array', 'exists:recipes,id'],
        ]);

        // load section's recipes with pivot data
        $section->load('recipes');

        foreach ($request->recipes as $index => $recipeId) {
            $section->recipes()->updateExistingPivot($recipeId, ['order' => $index]);
        }

        return back();
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'force_hide' => ['nullable', 'boolean'],
        ]);

        $section->update([
            'title' => $request->title,
            'description' => $request->description,
            'force_hide' => $request->force_hide,
        ]);

        return to_route('console.sections.index');
    }

    public function toggle(Section $section)
    {
        $section->update(['force_hide' => !$section->force_hide]);

        return back();
    }
}
