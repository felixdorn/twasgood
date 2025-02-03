<x-backend-layout title="Recettes">
    <x-slot:header>
        <a href="{{ route('console.recipes.create') }}">
            <x-button> Créer une recette </x-button>
        </a>
    </x-slot:header>
    <x-tabs class="mt-4">
        <x-tab-item :active="$state === 'published'" value="published">Publiées ({{ $published_count }})</x-tab-item>
        <x-tab-item :active="$state === 'unpublished'" value="unpublished">Brouillons ({{ $unpublished_count }})</x-tab-item>
    </x-tabs>

    @if (count($recipes) > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-4">
            @foreach ($recipes as $recipe)
                <x-recipe-card :recipe="$recipe" :excerpt-only="false" :href="route('console.recipes.edit', $recipe)" />
            @endforeach
        </div>
    @else
        <div class="mt-4 bg-white rounded-xl">
            Aucune recette.
        </div>
    @endif
</x-backend-layout>
