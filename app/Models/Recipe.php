<?php

namespace App\Models;

use App\Actions;
use App\Enums\RecipeLabel;
use App\Enums\RecipeType;
use App\Enums\Season;
use App\Models\Concerns\HasSlugs;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use Laravel\Scout\Searchable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Tiptap\Editor;

class Recipe extends Model implements HasMedia
{
    use HasFactory;
    use HasSlugs;
    use InteractsWithMedia;
    use Searchable;
    use SoftDeletes;

    protected $casts = [
        'uses_sterilization' => 'boolean',
    ];
    /**
     * @return array<string,mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'category_id' => $this->category_id,
            'labels' => $this->getLabels(),
            'is_published' => $this->published_at !== null,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->deleted_at === null && $this->published_at !== null;
    }

    public function getLabels(): array
    {
        $labels = [];

        $enrichment = (object) (new Actions\LabelRecipes())($this);

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
                RecipeType::ForAllOccasions => throw new \RuntimeException("Should not happen")
            };
        }

        return $labels;
    }

    protected static function booted(): void
    {
        /*
        static::updating(function (self $recipe) {
            $recipe->publishable = ! $recipe->mustBeDraft();

            // if any field other than published_at is updated, we reset the published_at field
            if ($recipe->isDirty() && ! $recipe->isDirty('published_at')) {
                $recipe->published_at = null;
            } else {
            }
        });
        */
    }

    public function mustBeDraft(): bool
    {
        return true;
        /*
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
        */
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('illustrations')
            ->withResponsiveImages();

        $this->addMediaCollection('banner')
            ->withResponsiveImages()
            ->singleFile();

        $this->addMediaConversion('default')->format('webp');

        $this->addMediaConversion('thumb')
            ->withResponsiveImages()
            ->format('webp')
            ->fit(Fit::Crop, 1600, 900)
            ->width(1600)
            ->height(900);
    }

    public function banner(): MorphMany
    {
        return $this->media()->where('collection_name', 'banner');
    }

    public function illustrations(): MorphMany
    {
        return $this->media()->where('collection_name', 'illustrations');
    }
    /**
     * @return BelongsToMany<Tag,covariant Recipe>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    /**
     * @return BelongsTo<Category,covariant Recipe>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * @return HasMany<Prerequisite,covariant Recipe>
     */
    public function prerequisites(): HasMany
    {
        return $this->hasMany(Prerequisite::class);
    }
    /**
     * @return BelongsTo<User,covariant Recipe>
     */
    public function author(): BelongsTo
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
                $html = (new Editor())->setContent(json_decode($this->content, associative: true, flags: JSON_THROW_ON_ERROR))->getHTML();

                return new HtmlString($html);
            }
        );
    }
}
