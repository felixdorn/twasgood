<x-frontend-layout title="Chercher des recettes">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">
            Résultats pour « {{ $query }} »
        </h1>

        @isset($recipes['error'])
            <p class="text-red-500 text-lg mt-4">Une erreur s'est produite. Veuillez réssayer plus tard.</p>
        @else
            @if (count($recipes['results']) > 0)
                <div class="grid grid-cols-3 gap-x-8 mt-4">
                    @foreach ($recipes['results'] as $recipe)
                        <a href="{{ route('recipes.show', $recipe->slug->slug) }}"
                            class="flex flex-col rounded-xl shadow-lg max-w-lg w-full bg-white mb-8">
                            <img loading="lazy" src="{{ $recipe->banner->small() }}" alt="{{ $recipe->banner->alt }}"
                                class="w-full rounded-t-xl" />
                            <div class="flex flex-col flex-1 px-6 py-4">
                                <h2 class="text-xl font-semibold">{{ $recipe->title }}</h2>
                                <p class="text-gray-500 mt-1">{{ $recipe->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-lg mt-2.5">Aucun résultat.</p>
            @endif
        </div>
        @endif
    </x-frontend-layout>
