<?php

namespace App\Console\Commands;

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
        if (! TagGroup::where('name', 'recipe_type')->exists()) {
            $group = TagGroup::create(['name' => 'recipe_type']);

            Tag::create(['group_id' => $group, 'name' => 'Apéro']);
            Tag::create(['group_id' => $group, 'name' => 'Goûter']);
            Tag::create(['group_id' => $group, 'name' => 'Entrée']);
            Tag::create(['group_id' => $group, 'name' => 'Plat']);
            Tag::create(['group_id' => $group, 'name' => 'Dessert']);

            $this->components->task('Created recipe_type tags');
        }

        if (! TagGroup::where('name', 'seasons')->exists()) {
            $group = TagGroup::create(['name' => 'seasons']);

            Tag::create(['group_id' => $group->id, 'name' => Season::All->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Spring->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Summer->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Autumn->value]);
            Tag::create(['group_id' => $group->id, 'name' => Season::Winter->value]);

            $this->components->task('Created seasons tags');
        }
    }
}
