<?php

namespace App\Enums;

enum RecipeType: string
{
    case Apero = 'apero';
    case Snack = 'snack';
    case Starter = 'starter';
    case Dish = 'dish';
    case Desert = 'desert';
    case ForAllOccasions = 'for_all_occasions';

    public function label(): string
    {
        return match ($this) {
            self::Apero => "Pour l'apéro",
            self::Snack => 'Pour le goûter',
            self::Starter => "Pour l'entrée",
            self::Dish => 'Pour le plat principal',
            self::Desert => 'Pour le dessert',
            self::ForAllOccasions => 'Pour toute occasion'
        };
    }
}
