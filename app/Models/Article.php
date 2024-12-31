<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset|null $banner
 * @property-read mixed $publishable
 * @property-read \App\Models\Section|null $section
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function emptyWith(string $title)
    {
        return self::create([
            'title' => $title,
            'description' => '(vide)',
            'content' => '{"type":"doc","content":[]}',
        ]);
    }

    protected static function booted()
    {
    }

    public function publishable(): Attribute
    {
        return new Attribute(function () {
            return ! $this->mustBeDraft();
        });
    }

    public function mustBeDraft(): bool
    {
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

    public function section()
    {
        return $this->hasOne(Section::class);
    }

    public function banner()
    {
        $banner = $this->hasOneThrough(Asset::class, Article::class, 'id', 'resource_id', 'id')
            ->where('group', 'banner:unique')
            ->where('resource_type', 'article');

        return $banner;
    }
}
