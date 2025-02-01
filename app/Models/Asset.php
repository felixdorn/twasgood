<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read Model|\Eloquent $resource
 * @property-read mixed $url
 *
 * @method static \Database\Factories\AssetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 *
 * @mixin \Eloquent
 */
class Asset extends Model
{
    use HasFactory;

    public $appends = ['url'];

    public function resource()
    {
        return $this->morphTo();
    }

    private function imgproxyUrl(string $processingOptions): string
    {
        return '';
        throw new \Exception('Unimplemented');
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->imgproxyUrl('width:1814/height:1014');
            }
        );
    }

    public function small(): string
    {
        return $this->imgproxyUrl('width:907/height:507');
    }

    public function pixel(): string
    {
        return $this->imgproxyUrl('width:48/height:48');
    }
}
