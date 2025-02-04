<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> **/
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('portrait')
            ->withResponsiveImages()
            ->singleFile();
    }

    public function portrait(): MorphMany
    {
        return $this->media()->where('collection_name', 'portait');
    }
}
