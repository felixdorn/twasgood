<?php

namespace App\Models;

use App\Enums\RecipeLabel;
use App\Enums\RecipeType;
use App\Enums\Season;
use App\Models\Concerns\HasSlugs;
use App\Services\RecipeEnrichment\RecipeEnricher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Tiptap\Editor;

/**
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string|null $time_to_prepare
 * @property bool $uses_sterilization
 * @property string $content
 * @property int $publishable
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\User|null $author
 * @property-read \App\Models\Category $category
 * @property-read mixed $html
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $illustrations
 * @property-read int|null $illustrations_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
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
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe wherePublishable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTimeToPrepare($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUsesSterilization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Recipe extends Model implements HasMedia
{
    use HasSlugs;
    use InteractsWithMedia;
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
            'category_id' => $this->category_id,
            'labels' => $this->getLabels(),
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->deleted_at === null && $this->published_at !== null;
    }

    public function getLabels(): array
    {
        $labels = [];

        $enrichment = RecipeEnricher::enrich($this);

        if ($enrichment->isVegan) {
            $labels[] = RecipeLabel::IsVegan;
        }

        if ($enrichment->isVegetarian) {
            $labels[] = RecipeLabel::IsVegetarian;
        }

        if ($enrichment->containsGluten) {
            $labels[] = RecipeLabel::ContainsGluten;
        }

        if ($enrichment->containsDairy) {
            $labels[] = RecipeLabel::ContainsDairy;
        }

        $seasons = $this->tags()->where('tag_group_id', TagGroup::where('name', 'seasons')->sole(['id'])->id)->get();
        foreach ($seasons as $season) {
            $labels[] = match (Season::from($season->name)) {
                Season::Spring => RecipeLabel::ForSpring,
                Season::Winter => RecipeLabel::ForWinter,
                Season::Summer => RecipeLabel::ForSummer,
                Season::Autumn => RecipeLabel::ForAutumn,
                Season::All => RecipeLabel::ForAllSeason
            };
        }

        $types = $this->tags()->where('tag_group_id', TagGroup::where('name', 'recipe_type')->sole(['id'])->id)->get();
        foreach ($types as $type) {
            $labels[] = match (RecipeType::from($type->name)) {
                RecipeType::Apero => RecipeLabel::ForApero,
                RecipeType::Snack => RecipeLabel::ForSnack,
                RecipeType::Starter => RecipeLabel::ForStarter,
                RecipeType::Dish => RecipeLabel::ForDish,
                RecipeType::Desert => RecipeLabel::ForDesert,
            };
        }

        return $labels;
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
        return $this->tags();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('illustrations')
            ->withResponsiveImages();

        $this->addMediaConversion('default')
            ->format('webp')
            ->nonQueued();

        $this->addMediaCollection('banner')
            ->withResponsiveImages()
            ->singleFile();
    }

    public function banner()
    {
        return $this->media()->where('collection_name', 'banner');
    }

    public function illustrations(): MorphMany
    {
        return $this->media()->where('collection_name', 'illustrations');
    }

    public function prerequisites(): HasMany
    {
        return $this->hasMany(Prerequisite::class);
    }

    public function slugs(): MorphMany
    {
        return $this->morphMany(Slug::class, 'sluggable');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function publish(): void
    {
        $this->update(['published_at' => now()]);
    }

    public function html(): Attribute
    {
        return new Attribute(
            function () {
                $html = (new Editor)->setContent(json_decode($this->content, associative: true, flags: JSON_THROW_ON_ERROR))->getHTML();

                return new HtmlString($html);
            }
        );
    }
}
