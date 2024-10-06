<?php

namespace App\Console\Commands;

use App\Enums\Season;
use App\Models\Tag;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    protected $signature = 'setup';

    protected $description = 'Setup the application (run only once)';

    public function handle(): void
    {
        if (! Tag::where('name', 'recipe_type')->exists()) {
            $group = Tag::create([
                'name' => 'recipe_type',
                'phantom' => true,
            ])->id;

            Tag::create(['group_id' => $group, 'name' => 'Apéro']);
            Tag::create(['group_id' => $group, 'name' => 'Goûter']);
            Tag::create(['group_id' => $group, 'name' => 'Entrée']);
            Tag::create(['group_id' => $group, 'name' => 'Plat']);
            Tag::create(['group_id' => $group, 'name' => 'Dessert']);

            $this->components->task('Created recipe_type tags');
        }

        if (! Tag::where('name', 'seasons')->exists()) {
            $group = Tag::create([
                'name' => 'seasons',
                'phantom' => true,
            ]);

            Tag::create(['group_id' => $group->id, 'name' => Season::All->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Spring->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Summer->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Autumn->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Winter->value]);

            $this->components->task('Created seasons tags');
        }

        if (! Tag::where('name', 'hot_cold')->exists()) {
            $group = Tag::create([
                'name' => 'hot_cold',
                'phantom' => true,
                'only_one' => true,
            ]);

            Tag::create(['group_id' => $group->id, 'name' => 'Quand il fait chaud']);
            Tag::create(['group_id' => $group->id, 'name' => 'Quand il fait froid']);

            $this->components->task('Created hot_cold tags');
        }
    }
}
