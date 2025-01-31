<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TagGroup extends Model
{
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
