<x-layouts.console title="Créer une recette">
    <h1 class="text-2xl font-semibold text-gray-900">
        <form
            method="post"
            action="{{ route('console.recipes.store') }}"
        >
            @csrf
            <div class="mt-4">
            <x-input-label for="title">Titre de la recette</x-input-label>
            <x-input name="title" autofocus placeholder="Example: Soupe de potiron" />
            </div>
            <x-button type="submit" class="mt-4">
                Créer
            </x-button>
        </form>
</x-layouts.console>
