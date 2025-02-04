<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Prerequisite;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $author = User::factory()->create();

        $categories = Category::factory()->count(6)->create();

        $recipes = Recipe::factory()
            ->count(100)
            ->for($author, 'author')
            ->for(fake()->randomElement($categories), 'category')
            ->create();
    }
}
