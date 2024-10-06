<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use Concerns\HasDiagnoses, HasFactory;

    public function resource()
    {
        return $this->morphTo();
    }

    public function diagnose() {}
}
