<div class="absolute w-full">
    <div class="bg-white max-w-lg mx-auto mt-4 rounded-xl relative w-full shadow-xl">
        @if ($recipes->isEmpty())
            <div>
                <p class="text-gray-700 px-4 py-2">Aucun résultat pour «{{ $query }}»</p>
            </div>
        @else
            <ul>
                @foreach ($recipes as $recipe)
                    <li>
                        <a href="{{ route('recipes.show', ['recipe' => $recipe->slug->slug]) }}"
                            class="px-4 flex rounded-xl py-2 focus:ring-emerald-600 focus:ring focus:outline-none hover:bg-gray-100 transition ">

                            <div>
                                <span class="font-semibold block">{{ $recipe->title }}</span>
                                <p
                                    class="block text-gray-700 max-w-[21ch] sm:max-w-[calc(32rem-6rem)] truncate mt-0.5 pr-4">
                                    {{ $recipe->description }}
                                </p>
                            </div>
                        </a>
                    </li>
                @endforeach
                <li class="bg-gray-50 rounded-b-xl px-4 py-2.5 mt-[4px]">
                    <a id="show-all-results" class="underline lg:no-underline lg:hover:underline"
                        href="{{ route('search', ['query' => $query]) }}">
                        Afficher tous les résultats &rarr;
                    </a>
                </li>
            </ul>
        @endif
    </div>
</div>
