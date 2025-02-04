<?php

namespace App\Models;

use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use HasSlugs;
    use SoftDeletes;

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Category $category) {
            $category->regenerateSlug();
        });
    }
    /**
     * @return HasMany<Recipe,Category>
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
