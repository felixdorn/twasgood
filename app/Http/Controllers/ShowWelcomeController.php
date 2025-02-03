<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Contracts\View\View;

class ShowWelcomeController
{
    public function __invoke(): View
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
            //'categories' => Category::withcount('recipes')->where('hidden', false)->get()
        ]);
    }
}
