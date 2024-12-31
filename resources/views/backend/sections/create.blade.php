<x-backend-layout title="Créer une nouvelle partie" width="max-w-2xl">
    <h1 class="text-2xl font-semibold text-gray-900">
        <form method="post" action="{{ route('console.sections.store') }}">
            @csrf
            <div class="mt-4">
                <x-input-label for="title">Titre de la partie</x-input-label>
                <x-input name="title" autofocus placeholder="5 recettes pour se rafraichir" />
                <x-input-error name="title" />
            </div>
            <x-button type="submit" class="mt-4">
                Créer
            </x-button>
        </form>
</x-backend-layout>
