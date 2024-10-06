<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use DB;
use Inertia\Inertia;

class CategoriesController
{
    public function index()
    {
        return inertia('Console/Category/Index', [
            'categories' => Category::query()
                ->addSelect(['id', 'name', DB::raw("(CASE WHEN name <> 'Sans catégorie' THEN true ELSE false END) as deletable")])
                ->orderBy('updated_at', 'desc')
                ->withCount('recipes')
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
        return Inertia::modal('Console/Category/Create')->baseRoute('console.categories.index');
    }

    public function edit(Category $category)
    {
        return Inertia::modal('Console/Category/Edit', [
            'category' => $category->load('slugs'),
        ])->baseRoute('console.categories.index');
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return to_route('console.categories.index');
    }
}
