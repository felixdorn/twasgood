<?php

namespace App\Models\Concerns;

use App\Models\Slug;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlugs
{
    public static function bootHasSlugs()
    {
        static::created(function (self $model) {
            $model->generateSlug();
        });

        static::updated(function (self $model) {
            $model->generateSlug();
        });
    }

    public function generateSlug(): Slug
    {
        $newSlug = Str::slug($this->getSluggableValue());

        if ($this->slug && $this->slug->slug === $newSlug) {
            return $this->slug;
        }

        return $this->slugs()->create([
            'slug' => $newSlug,
        ]);
    }

    public function slug()//: Attribute
    {
        return $this
            ->hasOneThrough(Slug::class, static::class, 'id', 'sluggable_id')
            ->where('sluggable_type', $this->getMorphClass())
            ->latest();
    }

    public function getSluggableValue()
    {
        return $this->title ?? $this->name;
    }

    public function slugs()
    {
        return $this->morphMany(Slug::class, 'sluggable');
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $slug = Slug::query()
            ->where('sluggable_type', $this->getMorphClass())
            ->when(preg_match('/^[0-9]+$/', $value), function ($query) use ($value) {
                $query->where('sluggable_id', $value);
            }, function ($query) use ($value) {
                $query->where('slug', $value);
            })
            ->first();

        if (! $slug || ! $slug->sluggable || ! $this->shouldShow($slug->sluggable)) {
            abort(404);
        }

        return $slug->sluggable;
    }

    public function shouldShow(Model $model)
    {
        return true;
    }
}
