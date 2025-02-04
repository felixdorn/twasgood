<?php

namespace App\Models;

use App\Enums\IngredientType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    /** @use HasFactory<\Database\Factories\IngredientFactory> **/
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'type' => IngredientType::class,
    ];
    /**
     * @return MorphMany<Prerequisite,Ingredient>
     */
    public function prerequisites(): MorphMany
    {
        return $this->morphMany(Prerequisite::class, 'prerequisite');
    }
}
