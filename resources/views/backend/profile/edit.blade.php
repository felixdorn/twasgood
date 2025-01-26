    <x-backend-layout title="Editer le profil" width="max-w-2xl">

        <x-image-uploader :asset="$user->picture" :resource="$user->id" :resourceType="'user'" group="portrait:unique" />


        <form action="{{ route('console.profile.update') }}" method="post" class="mt-6">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="name">Nom</x-input-label>
                <x-input class="mt-0.5" name="name" type="text" value="{{ $user->name }}" />
                <x-input-error name="name" />
            </div>

            <div class="mt-4">
                <x-input-label for="description">Description</x-input-label>
                <textarea id="description" name="description" aria-label="Description"
                    class="resize-none w-full border border-gray-300 mt-0.5 focus:ring-brand-600 focus:border-brand-600" rows="3">{{ $user->description }}</textarea>
                <x-input-error name="description" />
            </div>

            <x-button class="mt-6" type="submit">
                Mettre à jour
            </x-button>
        </form>
    </x-backend-layout>
