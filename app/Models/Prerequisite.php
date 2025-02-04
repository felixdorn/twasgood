<?php

namespace App\Models;

use App\Enums\PrerequisiteType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Prerequisite extends Pivot
{
    /** @use HasFactory<\Database\Factories\PrerequisiteFactory> **/
    use HasFactory;

    // Apparently this is needed, or Laravel uses prerequisite as the table name
    // Had no will power left in me to debug it
    // TODO: will power is back, fix this.
    protected $table = 'prerequisites';

    protected $casts = [
        'optional' => 'boolean',
    ];

    // TODO: Is this used?
    protected $appends = ['type'];
    /**
     * @return MorphTo<Model,Prerequisite>
     */
    public function prerequisite(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): Attribute
    {
        return new Attribute(
            fn () => PrerequisiteType::from($this->prerequisite_type)
        );
    }
    /**
     * @return BelongsTo<Recipe,Prerequisite>
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
