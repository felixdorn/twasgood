@props(['resourceType', 'resource', 'asset', 'group'])

<form
    action="{{ route('console.assets.upload', [
        'resource_type' => $resourceType,
        'resource_id' => $resource,
        'asset_id' => $asset,
        'group' => $group,
    ]) }}"
    method="post" enctype="multipart/form-data">
    @csrf
    <div>
        <x-input-label for="asset">Photo de profil</x-input-label>
        <input type="file" name="asset" class="mt-0.5" />
    </div>


    <x-button class="mt-4" type="submit">
        Mettre à jour
    </x-button>
</form>
