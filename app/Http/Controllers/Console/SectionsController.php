<?php

namespace App\Http\Controllers\Console;

use App\Models\Article;
use App\Models\Recipe;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionsController
{
    public function index()
    {
        return inertia('Console/Sections/Index', [
            'sections' => Section::with([
                'recipes' => fn ($query) => $query->with('banner'),
            ])->orderBy('order')->get(),
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

    public function associateArticle(Section $section, Article $article)
    {
        $section->update([
            'article_id' => $article->id,
        ]);

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

    public function dissociateArticle(Section $section)
    {
        $section->update([
            'article_id' => null,
        ]);

        return back();
    }
}
