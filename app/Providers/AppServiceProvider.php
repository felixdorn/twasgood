<?php

namespace App\Providers;

use App\Models\Article;
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
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        //Model::shouldBeStrict(!app()->isProduction());
        Model::unguard();

        if (config('imgproxy.key_file')) {
            $key = trim(file_get_contents(base_path(config('imgproxy.key_file'))));
            config()->set('imgproxy.key', $key);
        }

        if (config('imgproxy.salt_file')) {
            $salt = trim(file_get_contents(base_path(config('imgproxy.salt_file'))));
            config()->set('imgproxy.salt', $salt);
        }

        Relation::enforceMorphMap([
            'article' => Article::class,
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

        Facades\View::composer('*', function (View $view) {
            $view->with(
                'categories',
                Category::query()
                    ->where('hidden', false)
                    ->with(['slug' => fn ($query) => $query->select(['slug', 'slugs.created_at'])])
                    ->get()
            );
        });

        app()->setLocale('fr');
    }
}
