<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $keyBin = pack('H*', trim(config('imgproxy.key')));
        $saltBin = pack('H*', trim(config('imgproxy.salt')));

        $path = sprintf('/%s/plain/s3://%s/%s', $processingOptions, config('filesystems.disks.s3.bucket'), $this->path);
        $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $saltBin.$path, $keyBin, true)), '+/', '-_'), '=');

        return sprintf('%s/%s%s', config('imgproxy.endpoint'), $signature, $path);
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
}
