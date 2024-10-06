<?php

namespace App\Models\Concerns;

use App\Models\Diagnosis;

trait HasDiagnoses
{
    public function diagnoses()
    {
        return $this->morphMany(Diagnosis::class, 'diagnosable');
    }
}
