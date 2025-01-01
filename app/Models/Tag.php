<?php

namespace App\Models;

use App\Models\Concerns\HasSlugs;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int|null $group_id
 * @property bool $phantom
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $only_one
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tag> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Slug|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slug> $slugs
 * @property-read int|null $slugs_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereOnlyOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag wherePhantom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Tag extends Model
{
    use HasSlugs, SoftDeletes;

    protected $casts = [
        'only_one' => 'boolean',
        'phantom' => 'boolean',
    ];

    public static function recipeTypeGroup()
    {
        return Cache::rememberForever('tag.recipe_type_group', function () {
            return self::where('phantom', true)->where('name', 'recipe_type')->first();
        });
    }

    public static function seasonGroup()
    {
        return Cache::rememberForever('tag.season_group', function () {
            return self::where('phantom', true)->where('name', 'seasons')->first('id');
        });
    }

    public static function hotColdGroup()
    {
        return Cache::rememberForever('tag.hot_cold_group', function () {
            return self::where('phantom', true)->where('name', 'hot_cold')->first('id');
        });
    }

    public function children()
    {
        return $this->hasMany(Tag::class, 'group_id');
    }
}
