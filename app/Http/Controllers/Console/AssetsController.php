<?php

namespace App\Http\Controllers\Console;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetsController
{
    public function destroy(Asset $asset): Asset
    {
        $asset->delete();

        return $asset;
    }

    public function order(Request $request): array
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

    public function upload(Request $request): Asset
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

        $uploadedAsset = [
            'order' => $asset->order ?? Asset::query()
                ->where('resource_type', $request->resource_type)
                ->where('resource_id', $request->resource_id)
                ->where('group', $request->group)
                ->max('order') + 1,
        ];

        if ($request->has('asset')) {
            $file = $request->file('asset');
            Storage::disk('s3')->putFile(
                '',
                $file,
                $file->hashName()
            );

            $uploadedAsset['path'] = $file->hashName();
        }

        $uploadedAsset['alt'] = $request->alt ?? $asset->alt ?? '(vide)';

        $asset->update($uploadedAsset);

        return $asset;
    }
}
