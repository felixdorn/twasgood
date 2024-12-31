<?php

namespace App\Models;

use App\Enums\IngredientType;
use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property IngredientType $type
 * @property bool $contains_gluten
 * @property bool $contains_dairy
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prerequisite> $prerequisites
 * @property-read int|null $prerequisites_count
 * @property-read \App\Models\Slug|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slug> $slugs
 * @property-read int|null $slugs_count
 * @method static \Database\Factories\IngredientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereContainsDairy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereContainsGluten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient withoutTrashed()
 * @mixin \Eloquent
 */
class Ingredient extends Model
{
    use HasFactory;
    use HasSlugs;
    use SoftDeletes;

    protected $casts = [
        'type' => IngredientType::class,
    ];

    public function prerequisites(): MorphMany
    {
        return $this->morphMany(Prerequisite::class, 'prerequisite');
    }
}
