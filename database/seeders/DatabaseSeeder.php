<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Prerequisite;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $author = User::factory()->create([
            'name' => 'Charlotte Dorn',
        ]);

        Recipe::factory()
            ->count(100)
            ->for($author, 'author')
            ->has(Prerequisite::factory()->count(10))
            ->create();
    }
}
