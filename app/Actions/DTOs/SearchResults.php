<?php

namespace App\Actions\DTOs;

use Illuminate\Support\Arr;
use Meilisearch\Search\SearchResult;

class SearchResults
{
    public function __construct(
        public SearchResult $response,
        public array $query,
    ) {}

    public function ids(): array
    {
        return Arr::pluck($this->response->getHits(), 'id');
    }
}
