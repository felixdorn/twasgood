<?php

namespace App\View\Components;

use App\Actions\DTOs\SearchResults;
use App\Enums\RecipeLabel;
use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class RecipeSearch extends Component
{
    public array $facets;

    public function __construct(public ?SearchResults $old = null)
    {
        $facets = [
            ['op' => 'has_not', 'label' => RecipeLabel::ContainsDairy, 'active' => false],
            ['op' => 'has_not', 'label' => RecipeLabel::ContainsGluten, 'active' => false],
            ['op' => 'has', 'label' => RecipeLabel::IsVegetarian, 'active' => false],
            ['op' => 'has', 'label' => RecipeLabel::IsVegan, 'active' => false],
        ];

        if ($old !== null) {
            $rawFacets = $old->response->getFacetDistribution()['labels'];
            $hitCount = $old->response->getHitsCount();

            foreach ($facets as $k => $facet) {
                ['op' => $op, 'label' => $label] = $facet;

                $active = in_array($label->value, $old->query[$op]);
                $count = array_key_exists($label->value, $rawFacets) ? $rawFacets[$label->value] : 0;
                $mustKeep = $active === true || ($count > 0 && $count < $hitCount);

                $facets[$k]['active'] = $active;
                $facets[$k]['count'] = $count;
                $facets[$k]['must_keep'] = $mustKeep;
            }

            $facets = array_filter($facets, fn (array $facet) => $facet['must_keep']);
            // dd($facets);
        }

        $this->facets = $facets;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recipe-search');
    }
}
