<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriesController
{
    public function index(): View
    {
        return view('backend.categories.index', [
            'categories' => Category::query()
                ->withCount('recipes')
                ->orderBy('order')
                ->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return to_route('console.categories.index');
    }

    public function create(): View
    {
        return view('backend.categories.create');
    }

    public function edit(Category $category): View
    {
        return view('backend.categories.edit', [
            'category' => $category->load('slugs'),
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'subtitle' => $request->subtitle,
            'hidden' => $request->get('hidden', false) === 'on',
        ]);

        return back();
    }
}
