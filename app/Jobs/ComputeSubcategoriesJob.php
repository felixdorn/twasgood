<?php

namespace App\Jobs;

use App\Models\Category;
use App\Services\ComputedCategories;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeSubcategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Category $category) {}

    public function handle(): void
    {
        $properties = new ComputedCategories;

        foreach ($this->category->recipes as $recipe) {
            $properties->combine($recipe->computed_categories);
        }

        $this->category->update([
            'computed_available_subcategories' => $properties,
        ]);
    }
}
