<?php

namespace App\Enums;

enum IngredientType: string
{
    case Meat = 'meat';
    case Vegetarian = 'vegetarian';
    case Vegan = 'vegan';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Meat => 'Carné',
            self::Vegetarian => 'Végétarien',
            self::Vegan => 'Végétal',
            self::Other => 'Autre'
        };
    }
}
