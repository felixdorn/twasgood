<?php

namespace App\Models;

use App\Models\Concerns\HasSlugs;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
