<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB as IlluminateDB;

class OrderCategoriesController
{
    public function __invoke(Request $request): Response
    {
        $request->validate([
            'items' => ['required', 'array', 'exists:sections,id'],
        ]);

        IlluminateDB::transaction(function () use ($request) {
            foreach ($request->items as $index => $categoryId) {
                Category::where('id', $categoryId)->sole()->update(['order' => $index + 1]);
            }
        });

        return response('', 204);
    }
}
