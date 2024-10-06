<?php

namespace App\Models;

use App\Casts\ComputedCategoryCast;
use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected static ?self $defaultCategory = null;

    use HasFactory, HasSlugs, SoftDeletes;

    protected $casts = [
        'computed_available_subcategories' => ComputedCategoryCast::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Category $category) {
            $category->recipes->each(function (Recipe $recipe) {
                $recipe->update(['category_id' => Category::default()->id]);
            });
        });
    }

    public static function default(): Category
    {
        return static::$defaultCategory ??= Category::firstOrCreate([
            'name' => 'Sans catégorie',
        ]);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
