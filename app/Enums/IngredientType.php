<?php

namespace App\Enums;

enum IngredientType: string
{
    case Meat = 'meat';
    case Vegetarian = 'vegetarian';
    case Vegan = 'vegan';
    case Other = 'other';
}
