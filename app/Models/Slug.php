<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property string $sluggable_type
 * @property int $sluggable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $sluggable
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug whereSluggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug whereSluggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slug whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Slug extends Model
{
    use HasFactory;

    public function sluggable()
    {
        return $this->morphTo();
    }
}
