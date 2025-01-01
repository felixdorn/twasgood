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
        Model::shouldBeStrict(! app()->isProduction());
        Model::unguard();

        $keyFile = config('services.imgproxy.key_file', null);
        if (is_string($keyFile)) {
            $key = file_get_contents(
                file_exists($keyFile) ? $keyFile : base_path($keyFile)
            );

            config()->set('services.imgproxy.key', $key);
        }

        $saltFile = config('services.imgproxy.salt_file', null);
        if (is_string($saltFile)) {
            $salt = file_get_contents(
                file_exists($saltFile) ? $saltFile : base_path($saltFile)
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
