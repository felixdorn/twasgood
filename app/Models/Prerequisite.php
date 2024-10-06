<?php

namespace App\Models;

use App\Enums\PrerequisiteDisplayMode;
use App\Enums\PrerequisiteType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
