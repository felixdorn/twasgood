<?php

namespace App\Actions;

use App\Actions\DTOs\SearchResults;
use App\Enums\RecipeLabel;
use App\Enums\RecipeType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Meilisearch\Client;

class SearchRecipes
{
    public function __construct(
        public string $query = '',
        // The attributes to retrieve
        public array $select = ['id'],
        // The index the search runs on
        public string $index = 'recipes',
        public array $has = [],
        public array $hasNot = [],
        public RecipeType $occasion = RecipeType::ForAllOccasions,
        public ?int $category = null,
        public ?Client $meilisearch = null,
    ) {
        if ($this->meilisearch === null) {
            $this->meilisearch = app(Client::class);
        }
    }

    public static function fromRequest(Request $request, array $select = ['id'], string $index = 'recipes'): self
    {
        $data = collect($request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'has' => ['nullable', 'array'],
            'has.*' => [(new Enum(RecipeLabel::class))->only([RecipeLabel::IsVegan, RecipeLabel::IsVegetarian])],
            'has_not' => ['nullable', 'array'],
            'has_not.*' => [(new Enum(RecipeLabel::class))->only([RecipeLabel::ContainsDairy, RecipeLabel::ContainsGluten])],
            'occasion' => [new Enum(RecipeType::class)],
            'category' => ['nullable', 'exists:categories,id'],
        ]));

        return new self(
            query: $data->get('q') ?? '',
            select: $select,
            index: $index,
            has: $data->get('has', []),
            hasNot: $data->get('has_not', []),
            occasion: RecipeType::from($data->get('occasion', RecipeType::ForAllOccasions->value)),
            category: $data->get('category')
        );
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function run(): SearchResults
    {
        $comparisons = [];

        if ($this->category !== null) {
            $comparisons[] = ['category_id', '=', $this->category];
        }

        if ($this->occasion !== RecipeType::ForAllOccasions) {
            $recipeType = match ($this->occasion) {
                RecipeType::Apero => RecipeLabel::ForApero,
                RecipeType::Snack => RecipeLabel::ForSnack,
                RecipeType::Starter => RecipeLabel::ForStarter,
                RecipeType::Dish => RecipeLabel::ForDish,
                RecipeType::Desert => RecipeLabel::ForDesert,
            };

            $comparisons[] = ['labels', 'IN', '['.$recipeType->value.']'];
        }

        foreach ($this->has as $hasLabel) {
            $comparisons[] = ['labels', 'IN', '['.$hasLabel.']'];
        }

        foreach ($this->hasNot as $hasNotLabel) {
            $comparisons[] = ['labels', 'NOT IN', '['.$hasNotLabel.']'];
        }

        $filter = $this->buildFilter($comparisons);
        $results = $this->meilisearch->index($this->index)->search($this->query, [
            'filter' => $filter,
            'facets' => ['labels'],
            'attributesToRetrieve' => $this->select,
            'locales' => ['fr'],
            'limit' => 1000,
        ]);

        return new DTOs\SearchResults(
            response: $results,
            query: [
                'query' => $this->query,
                'category' => $this->category,
                'occasion' => $this->occasion,
                'has' => $this->has,
                'has_not' => $this->hasNot,
            ],
        );
    }

    protected function buildFilter(array $comparisons): string
    {
        $filter = '';

        while (count($comparisons) > 0) {
            $filter .= ' AND '.implode(' ', array_pop($comparisons));
        }

        return ltrim($filter, ' AND ');

    }
}
