<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadAssets extends Command
{
    protected $signature = 'app:upload-assets {path}';

    public function handle(): void
    {
        foreach (Asset::all() as $asset) {
            if (empty($asset->path)) {
                continue;
            }

            $base = rtrim($this->argument('path'), '/');
            $fullPath = $base.'/'.$asset->path;
            if (! file_exists($fullPath)) {
                $this->warn('Not found: '.$fullPath);

                continue;
            }

            $name = Storage::disk('s3')->putFile('', new File($fullPath));
            $asset->update(['path' => $name]);
        }
    }
}
