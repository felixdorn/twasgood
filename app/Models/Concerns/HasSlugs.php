<?php

namespace App\Models\Concerns;

use App\Models\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Throwable;

/**
 * @mixin Model
 */
trait HasSlugs
{
    public function regenerateSlug(): Slug
    {
        $newSlug = Str::slug($this->getSluggableValue());

        if ($this->slug && $this->slug->slug === $newSlug) {
            return $this->slug;
        }

        try {
            return $this->slugs()->create(['slug' => $newSlug]);
        } catch (Throwable $e) {
            dd($e);
        }
    }

    public function slug(): HasOneThrough
    {
        return $this
            ->hasOneThrough(Slug::class, static::class, 'id', 'sluggable_id')
            ->where('sluggable_type', $this->getMorphClass())
            ->orderByRaw('slugs.created_at DESC');
    }

    public function getSluggableValue()
    {
        return $this->title ?? $this->name ?? throw new \RuntimeException(sprintf('Could not create a slug for %s - no sluggable value', $this::class));
    }

    public function slugs(): MorphMany
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
            ->when(
                preg_match('/^[0-9]+$/', $value),
                fn ($query) => $query->where('sluggable_id', $value),
                fn ($query) => $query->where('slug', $value)
            )->first();

        if (! $slug || ! $slug->sluggable) {
            abort(404);
        }

        return $slug->sluggable;
    }
}
