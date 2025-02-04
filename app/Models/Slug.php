<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Slug extends Model
{
    /**
     * @return MorphTo<Model,covariant Slug>
     */
    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}
