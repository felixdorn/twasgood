<?php

namespace App\Services;

use App\Enums\RecipeComputedCategories;

class ComputedCategories
{
    /** @var int[] */
    public array $locks = [];

    public function __construct(public int $value = 0) {}

    /**
     * @param  RecipeComputedCategories  ...$properties
     * @return void
     */
    public function toggleAndLockIf(bool|callable $condition, ...$properties)
    {
        if (! value($condition)) {
            return;
        }
        foreach ($properties as $property) {
            if ($this->locked($property)) {
                continue;
            }

            $this->value ^= 1 << $property->position();
            $this->locks[$property->value] = true;
        }
    }

    /**
     * @param  RecipeComputedCategories  $property
     */
    public function locked($property): bool
    {
        return array_key_exists($property->value, $this->locks);
    }

    public function combine(self $other)
    {
        $this->value |= $other->value;

        return $this;
    }
}
