<?php

namespace App\Models;

use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property bool $hidden
 * @property string|null $description
 * @property string|null $subtitle
 * @property int $computed_available_subcategories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipe> $recipes
 * @property-read int|null $recipes_count
 * @property-read \App\Models\Slug|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slug> $slugs
 * @property-read int|null $slugs_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereComputedAvailableSubcategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;
    use HasSlugs;
    use SoftDeletes;
    protected static ?self $defaultCategory = null;

    protected static function boot(): void
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
