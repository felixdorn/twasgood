<?php

namespace App\Enums;

use PHPUnit\Exception;

enum RecipeLabel: string
{
    case IsVegan = 'is_vegan';
    case IsVegetarian = 'is_vegetarian';

    case ContainsGluten = 'contains_gluten';
    case ContainsDairy = 'contains_dairy';

    case ForApero = 'for_apero';
    case ForSnack = 'for_snack';
    case ForStarter = 'for_starter';
    case ForDish = 'for_dish';
    case ForDesert = 'for_desert';


    case ForSpring = 'for_spring';
    case ForSummer = 'for_summer';
    case ForAutumn = 'for_autumn';
    case ForWinter = 'for_winter';
    case ForAllSeason = 'for_all_season';

    public function filterLabel(): string
    {
        return match ($this) {
            self::IsVegan => "Végane",
            self::IsVegetarian => "Végétarien",
            self::ContainsDairy => "Sans lactose",
            self::ContainsGluten => "Sans gluten",
            default => throw new Exception("Unimplemented")
        };
    }
}
