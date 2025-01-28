<?php

namespace App\Http\Controllers;

use App\Models\Section;

class ShowWelcomeController
{
    public function __invoke()
    {
        $sections = Section::query()
            ->with([
                'recipes' => fn ($q) => $q->with(['slug', 'banner'])->get(['id', 'title', 'description']),
            ])
            ->whereNull('hidden_at')
            ->orderBy('order')
            ->get();

        return view('frontend.welcome', [
            'sections' => $sections,
        ]);
    }
}
