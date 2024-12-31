<x-backend-layout title="Créer une nouvelle partie" width="max-w-2xl">
    <form method="post" action="{{ route('console.sections.store') }}">
        @csrf
        <div class="mt-4">
            <x-input-label for="title">Titre de la partie</x-input-label>
            <x-input name="title" autofocus autocomplete="off" placeholder="5 recettes pour se rafraichir" />
            <x-input-error name="title" />
        </div>

        <div class="mt-4">
            <x-input-label for="description">Description</x-input-label>
            <x-input name="description" autocomplete="off" />
            <x-input-error name="description" />
        </div>

        <x-button type="submit" class="mt-4">
            Créer
        </x-button>
    </form>
</x-backend-layout>
