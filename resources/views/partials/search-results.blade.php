<div class="absolute w-full">
    <div class="bg-white max-w-lg mx-auto mt-2 border relative w-full shadow-2xl">
        @if ($recipes['results']->isEmpty())
            <div>
                <p class="text-gray-700 px-4 py-2">Aucun résultat pour «{{ $query }}»</p>
            </div>
        @else
            <ul>
                @foreach ($recipes['results'] as $recipe)
                    <li>
                        <a href="{{ route('recipes.show', ['recipe' => $recipe->slug->slug]) }}"
                            class="px-4 flex py-2 focus:ring-emerald-600 focus:ring focus:outline-none hover:bg-gray-100  transition ">

                            <div>
                                <span class="font-semibold block underline">{{ $recipe->title }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
                @if (count($recipes['results']) != $recipes['total'])
                    <li class="px-4 py-2.5 text-gray-700">
                        <a id="show-all-results" class="underline" href="{{ route('search', ['query' => $query]) }}">
                            Afficher tous les résultats ({{ $recipes['total'] }}) &rarr;
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</div>
