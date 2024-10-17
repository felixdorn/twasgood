<?php

namespace App\Models;

use App\Casts\ComputedCategoryCast;
use App\Models\Concerns\HasSlugs;
use App\Services\TiptapRenderer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Recipe extends Model
{
    use HasSlugs;
    use Searchable;
    use SoftDeletes;

    protected $casts = [
        'uses_sterilization' => 'boolean',
    ];

    public static function emptyWith(string $title): self
    {
        return self::create([
            'title' => $title,
            'short_title' => '(vide)',
            'description' => '(vide)',
            'time_to_prepare' => '(vide)',
            'content' => '{"type":"doc","content":[]}',
            'category_id' => Category::default()->id,
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    protected static function booted()
    {
        static::updating(function (self $recipe) {
            $recipe->publishable = ! $recipe->mustBeDraft();

            // if any field other than published_at is updated, we reset the published_at field
            if ($recipe->isDirty() && ! $recipe->isDirty('published_at')) {
                $recipe->published_at = null;
            } else {
            }
        });

    }

    public function mustBeDraft(): bool
    {
        if ($this->category_id === Category::default()->id) {
            return true;
        }

        foreach ($this->attributes as $attribute => $value) {
            if ($this->isAttributePlaceholder($attribute)) {
                return true;
            }
        }

        return false;
    }

    public function isAttributePlaceholder(string $attribute): bool
    {
        return $this->getAttribute($attribute) === '(vide)';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function state(): Attribute
    {
        return Attribute::get(function () {
            return $this->published_at === null ? 'unpublished' : 'published';
        });
    }

    public function seasons()
    {
        return $this->tags()->where('group_id', Tag::where('name', 'seasons')->sole()->id);
    }

    public function banner()
    {
        return $this->hasOneThrough(Asset::class, Recipe::class, 'id', 'resource_id', 'id')->where('group', 'banner:unique')->where('resource_type', 'recipe');
    }

    public function illustrations()
    {
        return $this->assets()->where('group', 'illustrations')->orderBy('order');
    }

    public function assets()
    {
        return $this->morphMany(Asset::class, 'resource');
    }

    public function prerequisites(): HasMany
    {
        return $this->hasMany(Prerequisite::class);
    }

    public function slugs()
    {
        return $this->morphMany(Slug::class, 'sluggable');
    }

    public function types()
    {
        return $this->tags()->where('group_id', Tag::where('name', 'recipe_type')->sole()->id);
    }

    public function publish()
    {
        $this->update(['published_at' => now()]);
    }

    public function html(): Attribute
    {
        return new Attribute(
            fn () => TiptapRenderer::process($this->content)
        );
    }
}
