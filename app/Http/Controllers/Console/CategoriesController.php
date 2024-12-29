<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController
{
    public function index()
    {
        return view('backend.categories.index', [
            'categories' => Category::query()
                ->addSelect(['id', 'name'])
                ->withCount('recipes')
                ->orderBy('updated_at', 'desc')
                ->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return to_route('console.categories.index');
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function edit(Category $category)
    {
        return view('backend.categories.edit', [
            'category' => $category->load('slugs'),
        ]);
    }

    public function update(Request $request, Category $category)
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
            'hidden' => $request->get('hidden', false) === 'on'
        ]);

        return back();
    }
}
