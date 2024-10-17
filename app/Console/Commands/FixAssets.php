<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FixAssets extends Command
{
    protected $signature = 'app:fix-assets';

    public function handle(): void
    {
        foreach (Asset::all() as $asset) {
            $exists = (Storage::exists('public/'.$asset->path));
            if (! $exists) {
                continue;
            }

            $name = Storage::disk('s3')->putFile('', new File(Storage::path('public/'.$asset->path)));

            $asset->update(['path' => $name]);
            dump($asset->fresh());
            break;
        }
    }
}
