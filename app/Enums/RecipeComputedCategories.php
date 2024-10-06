<?php

namespace App\Enums;

enum RecipeComputedCategories: string
{
    case IsNotVegan = 'is_not_vegan';
    case IsNotVegetarian = 'is_not_vegetarian';

    case ContainsGluten = 'contains_gluten';
    case ContainsDairy = 'contains_dairy';

    case IsPreDinnerDrink = 'is_pre_dinner_drink';
    case IsStarter = 'is_starter';
    case IsDinner = 'is_dinner';
    case IsDessert = 'is_dessert';
    case IsSnack = 'is_snack';

    public function shouldFilter(array $keys): bool
    {
        return in_array($this->value, $keys);
    }

    public function label(): string
    {
        return match ($this) {
            self::IsNotVegan => 'Végane',
            self::IsNotVegetarian => 'Végétarien',
            self::ContainsGluten => 'Sans gluten',
            self::ContainsDairy => 'Sans lactose',
            self::IsPreDinnerDrink => 'Apéro',
            self::IsStarter => 'Entrée',
            self::IsDinner => 'Plat',
            self::IsDessert => 'Dessert',
            self::IsSnack => 'Goûter',
        };
    }

    public function shouldHaveIt(): bool
    {
        return match ($this) {
            self::IsNotVegan, self::ContainsDairy, self::ContainsGluten, self::IsNotVegetarian => false,
            self::IsPreDinnerDrink, self::IsStarter, self::IsDinner, self::IsDessert, self::IsSnack => true,
        };
    }

    public function position(): int
    {
        // Can't do something clever with self::cases() because if we ever add a new case, that would break things.
        return match ($this) {
            self::IsNotVegan => 1,
            self::IsNotVegetarian => 2,
            self::ContainsGluten => 3,
            self::ContainsDairy => 4,
            self::IsPreDinnerDrink => 5,
            self::IsStarter => 6,
            self::IsDinner => 7,
            self::IsDessert => 8,
            self::IsSnack => 9,
        };
    }
}
