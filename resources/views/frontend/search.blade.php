<x-frontend-layout title="Chercher des recettes">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">
            Résultats pour « {{ $query }} »
        </h1>

        @isset($recipes['error'])
            <p class="text-red-500 text-lg mt-4">Une erreur s'est produite. Veuillez réssayer plus tard.</p>
        @else
            @if (count($recipes['results']) > 0)
                <div class="grid grid-cols-3 gap-x-8 gap-y-8 mt-4">
                    @foreach ($recipes['results'] as $recipe)
                        <x-recipe-card :recipe="$recipe" :excerpt-only="false" :href="route('recipes.show', $recipe->slug->slug)" />
                    @endforeach
                </div>
            @else
                <p class="text-lg mt-2.5">Aucun résultat.</p>
            @endif
        </div>
        @endif
    </x-frontend-layout>
