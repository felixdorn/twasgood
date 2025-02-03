<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackendLayout extends Component
{
    public function __construct(public string $title, public string $width = 'max-w-7xl')
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.backend-layout');
    }
}
