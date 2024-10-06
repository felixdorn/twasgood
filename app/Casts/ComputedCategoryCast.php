<?php

namespace App\Casts;

use App\Services\ComputedCategories;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ComputedCategoryCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return new ComputedCategories($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value->value;
    }
}
