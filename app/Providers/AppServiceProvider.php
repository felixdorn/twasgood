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
use Meilisearch\Client;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(! app()->isProduction());
        Model::unguard();

        $this->app->bind(Client::class, function () {
            return $client = new Client(
                config('scout.meilisearch.host'),
                config('scout.meilisearch.key'),
            );
        });
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
    }
}
