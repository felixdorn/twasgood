<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function complete()
    {
        $this->update(['completed_at' => now()]);

        return $this;
    }
}
