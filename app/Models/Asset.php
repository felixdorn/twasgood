<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $path
 * @property string|null $alt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $order
 * @property string|null $resource_type
 * @property int|null $resource_id
 * @property string|null $group
 * @property string|null $thumbnail_path
 * @property string|null $pixel_path
 * @property string|null $small_path
 * @property-read Model|\Eloquent|null $resource
 * @property-read mixed $url
 * @method static \Database\Factories\AssetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset wherePixelPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereResourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereResourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereSmallPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereThumbnailPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereUpdatedAt($value)
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
        $processingOptions = trim($processingOptions, '/');
        $keyBin = pack('H*', trim(config('services.imgproxy.key')));
        $saltBin = pack('H*', trim(config('services.imgproxy.salt')));

        $path = sprintf('/%s/plain/s3://%s/%s', $processingOptions, config('filesystems.disks.s3.bucket'), $this->path);
        $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $saltBin.$path, $keyBin, true)), '+/', '-_'), '=');

        return sprintf('%s/%s%s', config('services.imgproxy.endpoint'), $signature, $path);
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
