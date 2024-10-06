<?php

namespace App\Http\Controllers\Console;

use App\Enums\ActivationPeriodType;
use App\Models\ActivationPeriod;
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
            'activation_period_types' => ActivationPeriodType::cases(),
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
        return Inertia::modal('Console/Sections/Create')->baseRoute('console.sections.index');
    }

    public function edit(Section $section)
    {
        $section->load('recipes', 'activationPeriods', 'article');

        return \inertia('Console/Sections/Edit', [
            'section' => $section,
            'recipes' => Recipe::whereNotIn('id', $section->recipes->pluck('id'))->get(),
            'articles' => Article::where('published_at', '<>', null)->get(),
            'activation_period_types' => collect(ActivationPeriodType::cases())
                // remove types that are already in $section->activationPeriods
                ->filter(fn (ActivationPeriodType $type) => ! $section->activationPeriods->contains('type', $type))
                ->map(fn (ActivationPeriodType $type) => [
                    'id' => $type->name,
                    'name' => $type->value,
                    'title' => $type->title(),
                ])->values(),
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

    public function addActivationPeriod(Section $section, ActivationPeriodType $activationPeriodType)
    {
        abort_if(match ($activationPeriodType) {
            ActivationPeriodType::CustomDay, ActivationPeriodType::CustomRange, ActivationPeriodType::SomeSeasons => true,
            default => false,
        }, 404);

        $section->activationPeriods()->create([
            'type' => $activationPeriodType,
        ]);

        return back();
    }

    public function addCustomDate(Request $request, Section $section)
    {
        $section->activationPeriods()->create([
            'type' => ActivationPeriodType::CustomDay,
            'data' => [
                'date' => $request->date,
            ],
        ]);

        return back();
    }

    public function removeActivationPeriod(ActivationPeriod $activationPeriod)
    {
        $activationPeriod->delete();

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
