<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontendLayout extends Component
{
    public iterable $categories;

    public function __construct()
    {
        $this->categories = Category::query()
            ->where('hidden', false)
            ->with(['slug'])
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend-layout');
    }
}
