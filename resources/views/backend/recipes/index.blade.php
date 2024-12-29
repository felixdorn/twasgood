<x-backend-layout title="Recettes">
    <x-slot:header>
        <a href="{{ route('console.recipes.create') }}">
            <x-button> Créer une recette </x-button>
        </a>
    </x-slot:header>
    <div>

        <x-tabs>
            <x-tab-item :active="$state === 'published'" value="published">Publiées ({{ $published_count }})</x-tab-item>
            <x-tab-item :active="$state === 'unpublished'" value="unpublished">Brouillons ({{ $unpublished_count }})</x-tab-item>
        </x-tabs>


        @if (count($recipes) > 0)
            <div class="sm:columns-2 lg:columns-3 xl:columns-4 mt-4">
                @foreach ($recipes as $recipe)
                    <a href="{{ route('console.recipes.edit', $recipe) }}"
                        class="block mb-4 bg-white rounded-xl border group h-fit break-inside-avoid">
                        @if ($recipe->banner)
                            <img loading="lazy" src=" $recipe->banner->url" class="rounded-t-xl" height="507"
                                width="907" />
                        @else
                            <div v-else
                                class="flex justify-center items-center h-40 text-sm text-gray-700 bg-gray-50 rounded-t-xl border-b">
                                Pas d'aperçu disponible
                            </div>
                        @endif

                        <div class="py-3 px-5">
                            <h3 class="justify-between items-center md:flex">
                                <span class="text-lg group-hover:underline">{{ $recipe->title }}</span>
                            </h3>

                            @if ($recipe->description)
                                <p class="mt-2 max-w-xl text-gray-700 truncate">
                                    {{ $recipe->description }}
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mt-4 bg-white rounded-xl">
                Aucune recette.
            </div>
        @endif
</x-backend-layout>
