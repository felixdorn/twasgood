<?php

namespace App\Console\Commands;

use App\Enums\RecipeType;
use App\Enums\Season;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    protected $signature = 'setup';

    protected $description = 'Setup the application (run only once)';

    public function handle(): void
    {
        $group = TagGroup::firstOrCreate(['name' => 'recipe_type']);

        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => RecipeType::Apero->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => RecipeType::Snack->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => RecipeType::Starter->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => RecipeType::Dish->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => RecipeType::Desert->value]);

        $this->components->task('Created recipe_type tags');

        $group = TagGroup::firstOrCreate(['name' => 'seasons']);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => Season::All->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => Season::Spring->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => Season::Summer->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => Season::Autumn->value]);
        Tag::firstOrCreate(['tag_group_id' => $group->id, 'name' => Season::Winter->value]);

        $this->components->task('Created seasons tags');
    }
}
