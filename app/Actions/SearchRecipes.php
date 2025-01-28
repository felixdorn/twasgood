<?php

namespace App\Actions;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;

class SearchRecipes
{
    public function __invoke(string $query, int $limit = 5)
    {
        if (strlen($query) === 0) {
            return collect();
        }

        $total = Recipe::search($query)->query(fn (Builder $builder) => $builder->select('id'))->get()->count();

        $query = Recipe::search($query)
            ->query(
                fn (Builder $builder) => $builder
                    ->with('slug')
                    ->select('id', 'title')
            );

        if ($limit > 0) {
            $query->take($limit);
        }

        return ['total' => $total, 'results' => $query->get()];
    }
}
