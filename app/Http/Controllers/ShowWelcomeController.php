<?php

namespace App\Http\Controllers;

use App\Models\Section;

class ShowWelcomeController
{
    public function __invoke()
    {
        $sections = Section::query()
            ->with([
                'recipes' => fn ($q) => $q->with(['banner' => fn ($qb) => $qb->select(['alt', 'path']), 'slug'])->get(['id', 'title', 'description']),
            ])
            ->where('force_hide', false)
            ->orderBy('order')
            ->get();

        return view('welcome', [
            'sections' => $sections,
        ]);
    }
}
