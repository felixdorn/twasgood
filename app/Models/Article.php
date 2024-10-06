<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected static function booted() {}

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

    public function section(): BelongsTo
    {
        return $this->hasOne(Section::class);
    }

    public function banner()
    {
        $banner = $this->hasOneThrough(Asset::class, Article::class, 'id', 'resource_id', 'id')
            ->where('group', 'banner:unique')
            ->where('resource_type', 'article');

        //dd($banner->get());

        return $banner;
    }
}
