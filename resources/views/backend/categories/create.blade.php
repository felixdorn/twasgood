<x-backend-layout title="Créer une catégorie" width="max-w-2xl">
    <form method="post" action="{{ route('console.categories.store') }}">
        @csrf
        <div class="mt-4">
            <x-input-label for="name">Nom de la catégorie</x-input-label>
            <x-input name="name" autofocus placeholder="Example: Apéritifs" class="mt-1" />
        </div>
        <x-button type="submit" class="mt-4">
            Créer
        </x-button>
    </form>
</x-backend-layout>
