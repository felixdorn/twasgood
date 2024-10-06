<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class OrderSectionsController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'sections' => ['required', 'array', 'exists:recipes,id'],
        ]);

        $sections = Section::findMany($request->sections);

        foreach ($request->sections as $index => $sectionId) {
            $sections->where('id', $sectionId)->first()->update(['order' => $index + 1]);
        }

        return back();
    }
}
