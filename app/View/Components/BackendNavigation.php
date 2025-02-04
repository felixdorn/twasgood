<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackendNavigation extends Component
{
    public array $navigation;

    public function __construct(public bool $contained = true)
    {
        $this->navigation = [
            $this->addItem(
                label: 'Pages',
                route: 'console.pages.index',
            ),
            $this->addItem(
                label: 'Recettes',
                route: 'console.recipes.index',
            ),
            $this->addItem(
                label: 'Ingrédients',
                route: 'console.ingredients.index',
            ),
            $this->addItem(
                label: 'Catégories',
                route: 'console.categories.index',
            ),
        ];
    }

    private function addItem(string $label, string $route): array
    {
        return ['label' => $label, 'href' => route($route), 'active' => request()->routeIs($route)];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend-navigation');
    }
}
