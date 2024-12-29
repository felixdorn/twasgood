<x-backend-layout title="Créer une nouvelle partie">
    <h1 class="text-2xl font-semibold text-gray-900">
        <form method="post" action="{{ route('console.sections.store') }}">
            @csrf
            <div class="mt-4">
                <x-input-label for="name">Titre de la partie</x-input-label>
                <x-input name="name" autofocus placeholder="5 recettes pour se rafraichir" />
            </div>
            <x-button type="submit" class="mt-4">
                Créer
            </x-button>
        </form>
</x-backend-layout>
