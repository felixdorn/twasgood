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
        <nav class="max-h-screen overflow-y-auto" aria-label="Directory">
            @foreach ($ingredients as $letter => $group)
                <div class="relative">
                    <div
                        class="sticky top-0 z-50 border-y border-t-gray-100 bg-gray-50 px-3 py-1.5 font-semibold text-gray-900">
                        <h3>{{ $letter }}</h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-100">
                        @foreach ($group as $ingredient)
                            <li>
                                <a class="w-full flex items-center px-3 py-1.5 hover:bg-gray-50"
                                    href="{{ route('console.ingredients.edit', ['ingredient' => $ingredient]) }}">
                                    <span class="underline font-semibold text-gray-900">{{ $ingredient->name }}</span>


                                    @if ($ingredient->contains_gluten)
                                        <span
                                            class="ml-2 inline-flex items-center rounded-full bg-lime-100 px-1.5 py-0.5 text-xs font-medium text-lime-700">Gluten</span>
                                    @endif
                                    @if ($ingredient->contains_dairy)
                                        <span
                                            class="ml-2 inline-flex items-center rounded-full bg-pink-100 px-1.5 py-0.5 text-xs font-medium text-pink-700">Lactose</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>
    @else
        <div class="mt-4 bg-white rounded-xl">
            Aucun ingrédient.
        </div>
    @endif
</x-backend-layout>
