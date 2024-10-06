<?php

namespace App\Enums;

enum ActivationPeriodType: string
{
    case AllYear = 'all_year';
    case SomeSeasons = 'some_seasons';
    case Christmas = 'christmas';
    case Easter = 'easter';
    case Valentine = 'valentine';
    case CustomRange = 'custom_range';
    case CustomDay = 'custom_day';

    public function title(): string
    {
        return match ($this) {
            self::AllYear => 'Pendant les saisons de la recette',
            self::SomeSeasons => 'Pendant certaines saisons',
            self::Christmas => 'Pour Noël',
            self::Easter => 'Pour Pâques',
            self::Valentine => 'Pour la Saint-Valentin',
            self::CustomRange => 'Pendant une période personnalisée',
            self::CustomDay => 'Pour un jour en particulier',
        };
    }
}
