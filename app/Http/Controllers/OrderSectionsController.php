<?php

namespace App\Http\Controllers;

use App\Models\Section;
use DB;
use Illuminate\Http\Request;

class OrderSectionsController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'sections' => ['required', 'array', 'exists:recipes,id'],
        ]);

        DB::transaction(function () use ($request) {
            Section::whereNotIn('id', $request->sections)->update(['force_hide' => true, 'order' => 0]);

            foreach ($request->sections as $index => $sectionId) {
                Section::where('id', $sectionId)->sole()->update(['order' => $index + 1]);
            }
        });

        return response(204);
    }
}
