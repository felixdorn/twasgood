<x-frontend-layout title="Chercher des recettes">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">
            @if ($search?->query['query'] !== '')
                Résultats pour « {{ $search?->query['query'] ?? '' }} »
            @else
                Chercher des recettes
            @endif
        </h1>

        <div class="mt-4">
            <x-recipe-search :old="$search" />
        </div>

        <div class="relative mt-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white pr-2.5">{{ $search->response->getEstimatedTotalHits() }}
                    {{ Str::plural('résultat', $search->response->getEstimatedTotalHits()) }} </span>
            </div>
        </div>

        @if (count($recipes) > 0)
            <div class="grid lg:grid-cols-3 gap-x-8 gap-y-8 mt-2">
                @foreach ($recipes as $recipe)
                    <x-recipe-card :recipe="$recipe" :excerpt-only="false" :href="route('recipes.show', $recipe->slug->slug)" />
                @endforeach
            </div>
        @else
            <p class="text-lg mt-2.5">Aucun résultat.</p>
        @endif
    </div>
</x-frontend-layout>
