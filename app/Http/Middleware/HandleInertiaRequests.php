<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Felix\Navigation\Item;
use Felix\Navigation\Navigation;
use Felix\Navigation\Section;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],

            'flash' => [
                'alert' => $request->session()->get('alert'),
            ],

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },

            'categories' => fn () => Category::where('hidden', false)->with('slug')->get(),

            'navigation' => (new Navigation())
                ->addSection(
                    'Contenu',
                    fn (Section $section) => $section
                    ->add(
                        'Articles',
                        fn (Item $item) => $item
                        ->route('console.articles.index')
                        ->activeWhenRouteMatches('console.articles.*')
                        ->meta([
                            'icon' => 'view-columns',
                        ])
                    )
                    ->add('Recettes', fn (Item $item) => $item
                        ->route('console.recipes.index')
                        ->activeWhenRouteMatches('console.recipes.*')
                        ->meta([
                            'icon' => 'newspaper',
                        ]))
                    ->add(
                        'Parties',
                        fn (Item $item) => $item
                        ->route('console.sections.index')
                        ->activeWhenRouteMatches('console.sections.*')
                        ->meta([
                            'icon' => 'queue-list',
                        ])
                    )
                    ->add('Ingrédients', fn (Item $item) => $item
                        ->route('console.ingredients.index')
                        ->activeWhenRouteMatches('console.ingredients.*')
                        ->meta([
                            'icon' => 'cart',
                        ]))
                    ->add(
                        'Catégories',
                        fn (Item $item) => $item
                        ->route('console.categories.index')
                        ->activeWhenRouteMatches('console.categories.*')
                        ->meta([
                            'icon' => 'tag',
                        ])
                    )
                )
                ->toArray(),
        ]);
    }
}
