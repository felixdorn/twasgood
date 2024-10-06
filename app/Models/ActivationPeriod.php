<?php

namespace App\Models;

use App\Enums\ActivationPeriodType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ActivationPeriod extends Model
{
    protected $casts = [
        'type' => ActivationPeriodType::class,
        'data' => 'json',
    ];

    protected $appends = ['title'];

    public function title(): Attribute
    {
        return new Attribute(function () {
            return $this->type->title();
        });
    }
}
