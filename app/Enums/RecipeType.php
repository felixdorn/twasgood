
<?php

namespace App\Enums;

enum RecipeType: string
{
    case Apero = 'apero';
    case Snack = 'snack';
    case Starter = 'starter';
    case Dish = 'dish';
    case Desert = 'desert';
}
