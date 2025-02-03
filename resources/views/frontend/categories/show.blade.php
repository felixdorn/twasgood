<x-frontend-layout title="{{ $category->name }}{{ $category->subtitle ? ': ' . $category->subtitle : '' }}">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">{{ $category->name }}
            <span>: {{ $category->subtitle }}</span>
        </h1>

        <p class="max-w-prose text-lg text-gray-700 mt-3 text-balance">{{ $category->description }}</p>

        <div class="mt-8">
            <h3 class="text-lg font-semibold">Filtrer les recettes</h3>
            <x-recipe-search :old="$search" />
        </div>

        <div class="relative mt-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white pr-2.5">{{ $search->response->getEstimatedTotalHits() }}
                    {{ Str::plural('résultat', $search->response->getEstimatedTotalHits()) }} </span>
            </div>
        </div>

        @if (count($recipes) > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-2">
                @foreach ($recipes as $recipe)
                    <x-recipe-card :recipe="$recipe" :excerpt-only="false" :href="route('recipes.show', $recipe->slug->slug)" />
                @endforeach
            </div>
        @else
            <p class="text-lg mt-4">Aucune recette ne correspond à ces filtres.</p>
        @endif
</x-frontend-layout>
