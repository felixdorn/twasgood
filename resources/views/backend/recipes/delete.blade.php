<x-backend-layout width="max-w-xl">
    <x-slot:title>
        Supprimer la recette "{{ $recipe->title }}"
    </x-slot:title>

    <p class="mt-1 text-lg text-gray-700">
        Pour confirmer la suppression de la recette, veuillez taper son titre dans le champ de texte ci-dessous:
    </p>
    <form method="post" action="{{ route('console.recipes.destroy', $recipe) }}">
        @csrf
        @method('DELETE')
        <div class="mt-4">
            <x-input-label for="title">Titre de la recette</x-input-label>
            <x-input name="title" autofocus placeholder="{{ $recipe->title }}" />
            @error('title')
                <p class="mt-0.5 text-red-700">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex space-x-2 items-center mt-4">
            <x-buttons.danger type="submit">
                Supprimer
            </x-buttons.danger>
            <a href="{{ url()->previous() }}">
                <x-buttons.secondary type="button">
                    Annuler
                </x-buttons.secondary>
            </a>
        </div>
    </form>
</x-backend-layout>
