<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Prerequisite;
use App\Models\Recipe;
use App\Models\Section;
use App\Models\Slug;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());
        Model::unguard();

        if (config('services.imgproxy.key_file')) {
            $keyPath = config('services.imgproxy.key_file');
            $key = file_get_contents(
                file_exists($keyPath) ? $keyPath : base_path($keyPath)
            );
            config()->set('services.imgproxy.key', $key);
        }

        if (config('services.imgproxy.salt_file')) {
            $saltPath = config('services.imgproxy.salt_file');
            $salt = file_get_contents(
                file_exists($saltPath) ? $saltPath : base_path($saltPath)
            );
            config()->set('services.imgproxy.salt', $salt);
        }

        Relation::enforceMorphMap([
            'asset' => Asset::class,
            'category' => Category::class,
            'ingredient' => Ingredient::class,
            'prerequisite' => Prerequisite::class,
            'recipe' => Recipe::class,
            'section' => Section::class,
            'slug' => Slug::class,
            'tag' => Tag::class,
            'user' => User::class,
        ]);

        app()->setLocale('fr');
    }
}
