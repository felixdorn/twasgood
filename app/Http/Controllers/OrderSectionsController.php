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
            'items' => ['required', 'array', 'exists:sections,id'],
        ]);

        DB::transaction(function () use ($request) {
            Section::whereNotIn('id', $request->items)->update(['hidden_at' => now(), 'order' => 0]);

            foreach ($request->items as $index => $sectionId) {
                Section::where('id', $sectionId)->sole()->update(['order' => $index + 1]);
            }
        });

        return response(204);
    }
}
