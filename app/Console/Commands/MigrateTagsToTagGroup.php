<?php

namespace App\Console\Commands;

use App\Enums\RecipeType;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Console\Command;

class MigrateTagsToTagGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-tags-to-tag-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seasonsId = TagGroup::where('name', 'seasons')->sole()->id;
        $recipeTypeId = TagGroup::where('name', 'recipe_type')->sole()->id;
        foreach (Tag::with(['slug'])->get() as $tag) {
            if (in_array($tag->name, ['autumn', 'spring', 'summer', 'winter', 'all'])) {
                $tag->update(['tag_group_id' => $seasonsId]);
            }

            if (in_array($tag->name, ['Apéro', 'Entrée', 'Plat', 'Goûter', 'Dessert'])) {
                $tag->update([
                    'tag_group_id' => $recipeTypeId,
                    'name' => match ($tag->name) {
                        'Apéro' => RecipeType::Apero->value,
                        'Plat' => RecipeType::Dish->value,
                        'Entrée' => RecipeType::Starter->value,
                        'Goûter' => RecipeType::Snack->value,
                        'Dessert' => RecipeType::Desert->value
                    },
                ]);

            }
        }
    }
}
