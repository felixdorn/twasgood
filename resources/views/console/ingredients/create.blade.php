<x-layouts.console title="Créer une catégorie">
    <h1 class="text-2xl font-semibold text-gray-900">
        <form
            method="post"
            action="{{ route('console.categories.store') }}"
        >
            @csrf
            <div class="mt-4">
            <x-input-label for="name">Titre de la recette</x-input-label>
            <x-input name="name" autofocus placeholder="Example: Apéritifs" />
            </div>
            <x-button type="submit" class="mt-4">
                Créer
            </x-button>
        </form>
</x-layouts.console>
