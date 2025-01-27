<?php

namespace App\Models;

use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasSlugs;
}
