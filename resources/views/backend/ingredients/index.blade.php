<x-backend-layout title="Ingrédients">
    <x-slot:header>
        <a href="{{ route('console.ingredients.create') }}">
            <x-button>Nouvel ingrédient</x-button>
        </a>
    </x-slot:header>

    <x-tabs class="mt-1">
        <x-tab-item :active="$state === 'vegan'" value="vegan">Végétal</x-tab-item>
        <x-tab-item :active="$state === 'vegetarian'" value="vegetarian">Végétarien</x-tab-item>
        <x-tab-item :active="$state === 'meat'" value="meat">Carné</x-tab-item>
        <x-tab-item :active="$state === 'other'" value="other">Autres</x-tab-item>
    </x-tabs>

    @if (count($ingredients) > 0)
        <div class="gap-x-4 mt-4 columns-1 lg:columns-3 xl:columns-6">
            @foreach ($ingredients as $ingredient)
                <a href="{{ route('console.ingredients.edit', ['ingredient' => $ingredient]) }}"
                    class="block py-4 px-6 mb-4 bg-white rounded-xl border break-inside-avoid group">
                    <h3 class="justify-between items-center md:flex">
                        <span class="text-lg group-hover:underline">{{ $ingredient->name }}</span>
                        <span class="block text-gray-500 md:inline"> </span>
                    </h3>

                    @if ($ingredient->contains_gluten || $ingredient->contains_dairy)
                        <ul class="flex mt-1.5 space-x-2">
                            @if ($ingredient->contains_gluten)
                                <li>
                                    <span
                                        class="inline-flex items-center py-0.5 px-2.5 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">
                                        Gluten
                                    </span>
                                </li>
                            @endif
                            @if ($ingredient->contains_dairy)
                                <li>
                                    <span
                                        class="inline-flex items-center py-0.5 px-2.5 text-xs font-medium text-pink-800 bg-pink-100 rounded-full">
                                        Lactose
                                    </span>
                                </li>
                            @endif
                        </ul>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="mt-4 bg-white rounded-xl">
            Aucun ingrédient.
        </div>
    @endif
</x-backend-layout>
