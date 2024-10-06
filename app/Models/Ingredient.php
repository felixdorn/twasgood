<?php

namespace App\Models;

use App\Enums\IngredientType;
use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
