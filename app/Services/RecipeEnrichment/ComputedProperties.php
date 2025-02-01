<?php

namespace App\Services\RecipeEnrichment;

class ComputedProperties
{
    public function __construct(
        public bool $isVegan = true,
        public bool $isVegetarian = true,
        public bool $containsGluten = false,
        public bool $containsDairy = false,
    ) {}
}
