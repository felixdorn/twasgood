<?php

namespace App\Models;

use App\Models\Concerns\HasSlugs;
use App\Services\TiptapRenderer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string|null $time_to_prepare
 * @property string $content
 * @property bool $publishable
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $uses_sterilization
 * @property int $computed_categories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $assets
 * @property-read int|null $assets_count
 * @property-read \App\Models\Asset|null $banner
 * @property-read \App\Models\Category $category
 * @property-read mixed $html
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $illustrations
 * @property-read int|null $illustrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prerequisite> $prerequisites
 * @property-read int|null $prerequisites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $seasons
 * @property-read int|null $seasons_count
 * @property-read \App\Models\Slug|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slug> $slugs
 * @property-read int|null $slugs_count
 * @property-read mixed $state
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $types
 * @property-read int|null $types_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereComputedCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe wherePublishable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereShortTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTimeToPrepare($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUsesSterilization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Recipe extends Model
{
    use HasSlugs;
    use Searchable;
    use SoftDeletes;

    protected $casts = [
        'uses_sterilization' => 'boolean',
    ];

    public static function emptyWith(int $user, string $title): self
    {
        return self::create([
            'title' => $title,
            'description' => '(vide)',
            'time_to_prepare' => '(vide)',
            'user_id' => $user,
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

    protected static function booted(): void
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

    public function shouldGenerateSlugs(): bool
    {
        // TODO: Only store slug on publish
        return ! $this->mustBeDraft();
    }

    public function mustBeDraft(): bool
    {
        if ($this->category_id === Category::default()->id) {
            return true;
        }

        foreach ($this->attributes as $attribute => $value) {
            // We don't use short title anymore!
            if ($attribute === 'short_title') {
                continue;
            }

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

    public function tags(): BelongsToMany
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

    public function seasons(): BelongsToMany
    {
        return $this->tags()->where('group_id', Tag::where('name', 'seasons')->sole()->id);
    }

    public function banner(): HasOneThrough
    {
        return $this->hasOneThrough(Asset::class, Recipe::class, 'id', 'resource_id', 'id')->where('group', 'banner:unique')->where('resource_type', 'recipe');
    }

    public function illustrations(): MorphMany
    {
        return $this->assets()->where('group', 'illustrations')->orderBy('order');
    }

    public function assets(): MorphMany
    {
        return $this->morphMany(Asset::class, 'resource');
    }

    public function prerequisites(): HasMany
    {
        return $this->hasMany(Prerequisite::class);
    }

    public function slugs(): MorphMany
    {
        return $this->morphMany(Slug::class, 'sluggable');
    }

    public function types(): BelongsToMany
    {
        return $this->tags()->where('group_id', Tag::where('name', 'recipe_type')->sole()->id);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function publish(): void
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
