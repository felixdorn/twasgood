<?php

namespace App\Http\Controllers\Console;

use App\Models\Recipe;
use App\Models\Tag;

class ToggleTagController
{
    public function __invoke(Recipe $recipe, Tag $tag)
    {
        $recipe->tags()->toggle($tag->id);

        return back();
    }
}
