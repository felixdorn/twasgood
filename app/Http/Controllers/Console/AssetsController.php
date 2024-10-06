<?php

namespace App\Http\Controllers\Console;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AssetsController
{
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return $asset;
    }

    public function order(Request $request)
    {
        $request->validate([
            'assets' => ['required', 'array', 'distinct'],
            'assets.*' => ['numeric', 'exists:assets,id'],
        ]);

        $assets = [];

        foreach ($request->assets as $order => $assetId) {
            $asset = Asset::where('id', $assetId)->sole();

            $asset->update(['order' => $order]);

            $assets[] = $asset;
        }

        return $assets;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'resource_type' => ['required', 'string', 'max:255'],
        ]);

        $morphed = Relation::getMorphedModel($request->resource_type);

        abort_if(! $morphed, 404);

        $request->validate([
            'resource_id' => ['required', 'exists:'.(new $morphed)->getTable().',id'],
            'group' => ['string', 'max:255'],
            'asset_id' => ['exists:assets,id'],

            'asset' => ['nullable', 'image', 'max:8192'],
            'alt' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->has('asset_id') && $request->asset_id !== null) {
            $asset = Asset::find($request->asset_id);
            // Ultimately, if we need to support different kind of tags (other than unique), we'd need something more robust.
        } elseif ($request->has('group') && str_ends_with($request->group, ':unique')) {
            $asset = Asset::query()
                ->where('resource_id', $request->resource_id)
                ->where('resource_type', $request->resource_type)
                ->where('group', $request->group)
                ->first();
        }

        if (! isset($asset)) {
            $asset = Asset::create(
                $request->only('resource_type', 'resource_id', 'group')
            );
        }

        $payload = [
            'order' => $asset->order ?? Asset::query()
                ->where('resource_type', $request->resource_type)
                ->where('resource_id', $request->resource_id)
                ->where('group', $request->group)
                ->max('order') + 1,
        ];

        if ($request->has('asset')) {
            $resized = Storage::disk('public')->path('uploads');
            File::ensureDirectoryExists($resized);
            $file = $request->file('asset');

            Image::make($file)
                ->fit(907 * 2, 507 * 2)
                ->save($resized.'/'.$file->hashName(), 100, 'webp');

            Image::make($file)
                ->fit(907, 507)
                ->save($resized.'/small_'.$file->hashName(), 100, 'webp');

            Image::make($file)
                ->fit(907, 507)
                ->save($resized.'/thumbnail_'.$file->hashName(), 50, 'webp');

            Image::make($file)
                ->fit(48, 48)
                ->save($resized.'/pixel_'.$file->hashName(), 30, 'webp');

            $payload['path'] = 'uploads/'.$file->hashName();
            $payload['thumbnail_path'] = 'uploads/thumbnail_'.$file->hashName();
            $payload['pixel_path'] = 'uploads/pixel_'.$file->hashName();
            $payload['small_path'] = 'uploads/small_'.$file->hashName();
        }

        $payload['alt'] = $request->alt ?? $asset->alt ?? '(vide)';

        $asset->update($payload);

        return $asset;
    }
}
