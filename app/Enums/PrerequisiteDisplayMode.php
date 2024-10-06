<?php

namespace App\Enums;

enum PrerequisiteDisplayMode: string
{
    case QuantityNameThenDetails = 'QuantityNameThenDetails';
    case NameDetailsThenQuantity = 'NameDetailsThenQuantity';
}
