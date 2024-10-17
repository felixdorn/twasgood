<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $casts = [
        'force_hide' => 'boolean',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withPivot('order')->orderByPivot('order');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
