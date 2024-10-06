<?php

namespace App\Enums;

use App\Models\Article;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;

enum ResourceType: string
{
    case Ingredient = 'ingredient';
    case Recipe = 'recipe';
    case Category = 'category';
    case Article = 'article';

    /** @return class-string<Model> */
    public function model(): string
    {
        return match ($this) {
            ResourceType::Ingredient => Ingredient::class,
            ResourceType::Recipe => Recipe::class,
            ResourceType::Category => Category::class,
            ResourceType::Article => Article::class,
        };
    }

    public function title(): string
    {
        return match ($this) {
            ResourceType::Ingredient => "l'ingrédient",
            ResourceType::Category => 'la catégorie',
            ResourceType::Recipe => 'la recette',
            ResourceType::Article => "l'article",
        };
    }

    public function imageFields(): array
    {
        return match ($this) {
            ResourceType::Recipe => ['banner'],
            ResourceType::Article => ['banner'],
            default => []
        };
    }
}
