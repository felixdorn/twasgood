<?php

namespace App\Models;

use App\Enums\PrerequisiteType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property string|null $details
 * @property string $quantity
 * @property bool $optional
 * @property int|null $order
 * @property int $recipe_id
 * @property string $prerequisite_type
 * @property int $prerequisite_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read Model|\Eloquent $prerequisite
 * @property-read \App\Models\Recipe $recipe
 * @property-read mixed $type
 *
 * @method static \Database\Factories\PrerequisiteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereOptional($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite wherePrerequisiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite wherePrerequisiteType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prerequisite whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Prerequisite extends Pivot
{
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

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
