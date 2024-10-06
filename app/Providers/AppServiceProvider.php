<?php

namespace App\Providers;

use App;
use App\Models\ActivationPeriod;
use App\Models\Article;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Diagnosis;
use App\Models\Ingredient;
use App\Models\Prerequisite;
use App\Models\Recipe;
use App\Models\Section;
use App\Models\Slug;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use App\Observers\PrerequisiteObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        App::macro('isConsole', function () {
            if ($this->app->runningInConsole()) {
                return false;
            }

            /** @var Request $request */
            $request = $this->app->make('request');

            return $request->routeIs('console.*', 'login', 'register', 'password.*', 'sanctum.*', 'logout');
        });

        $this->app->useStoragePath(config('filesystems.storage_path'));
    }

    public function boot(): void
    {

        //Model::shouldBeStrict(!app()->isProduction());
        Model::unguard();

        Prerequisite::observe(PrerequisiteObserver::class);
        Relation::enforceMorphMap([
            'activation_period' => ActivationPeriod::class,
            'article' => Article::class,
            'asset' => Asset::class,
            'category' => Category::class,
            'diagnosis' => Diagnosis::class,
            'ingredient' => Ingredient::class,
            'prerequisite' => Prerequisite::class,
            'recipe' => Recipe::class,
            'section' => Section::class,
            'slug' => Slug::class,
            'tag' => Tag::class,
            'user' => User::class,
            'task' => Task::class,

        ]);

        app()->setLocale('fr');
    }
}
