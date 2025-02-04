<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TagGroup extends Model
{
    /**
     * @return HasMany<Tag,covariant TagGroup>
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
