<?php

namespace App\Actions;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchRecipes
{
    public function __invoke(string $query, int $limit = 5): Collection
    {
        if (strlen($query) === 0) {
            return collect();
        }

        $recipes = Recipe::search($query)
            ->query(
                fn (Builder $builder) => $builder
                ->with([
                    'slug',
                    'banner' => fn ($builder) => $builder->select('path', 'alt')
                ])
                ->select('id', 'title', 'description')
            )
            ->take($limit)->get();

        return $recipes;
    }
}
