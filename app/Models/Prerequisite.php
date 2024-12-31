<?php

namespace App\Models;

use App\Enums\PrerequisiteDisplayMode;
use App\Enums\PrerequisiteType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @property int $id
 * @property string|null $details
 * @property string $quantity
 * @property bool $optional
 * @property int $recipe_id
 * @property string $prerequisite_type
 * @property int $prerequisite_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $order
 * @property-read mixed $display_mode
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $prerequisite
 * @property-read \App\Models\Recipe $recipe
 * @property-read mixed $type
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
 * @mixin \Eloquent
 */
class Prerequisite extends Pivot
{
    // Apparently this is needed, or Laravel uses prerequisite as the table name
    // Had no will power left in me to debug it
    protected $table = 'prerequisites';

    protected $casts = [
        'optional' => 'boolean',
    ];

    protected $appends = ['type'];

    public function prerequisite()
    {
        return $this->morphTo();
    }

    public function type(): Attribute
    {
        return new Attribute(
            fn () => PrerequisiteType::from($this->prerequisite_type)
        );
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function displayMode(): Attribute
    {
        return new Attribute(function () {
            if (preg_match('/^[1-9][0-9]*$/', $this->quantity)) {
                return PrerequisiteDisplayMode::QuantityNameThenDetails;
            }

            return PrerequisiteDisplayMode::NameDetailsThenQuantity;
        });
    }
}
