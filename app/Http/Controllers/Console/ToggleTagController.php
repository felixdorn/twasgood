<?php

namespace App\Http\Controllers\Console;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;

class ToggleTagController
{
    public function __invoke(Recipe $recipe, Tag $tag): RedirectResponse
    {
        $recipe->tags()->toggle($tag->id);

        return back();
    }
}
