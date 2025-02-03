<?php

namespace App\View\Components\PageEditors;

use App\Models\Recipe;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Home extends Component {
    public $sections;
    public function __construct()
    {
        $this->sections = Section::with('recipes')->orderBy('order')->get();
    }

    public function render(): View {
        return view('components.page-editors.home', [
            'visible_sections' => $this->sections->whereNull('hidden_at'),
            'hidden_sections' => $this->sections->whereNotNull('hidden_at'),
            'recipes' => Recipe::whereNotNull('published_at')->get(['id', 'title']),
        ]);
    }

}
