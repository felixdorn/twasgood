<x-frontend-layout title="{{ $category->name }}{{ $category->subtitle ? ': ' . $category->subtitle : '' }}">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">{{ $category->name }}
            <span>: {{ $category->subtitle }}</span>
        </h1>

        <p class="max-w-prose text-lg text-gray-700 mt-3 text-balance">{{ $category->description }}</p>

        <div class="mt-8">
            <h3 class="text-lg font-semibold">Filtrer les recettes</h3>
            <form class="mt-2">
                <x-input name="query" />

                <div class="flex space-x-4 flex-nowrap overflow-x-scroll mt-2">
                    @foreach ($relevantFacets as $facet)
                        <div class="flex items-center">
                            <input type="checkbox" name="{{ $facet['type']->name }}" id="{{ $facet['type']->name }}"
                                class="sr-only peer" />
                            <label for="{{ $facet['type']->name }}" class="group peer-checked:bg-brand-600">
                                <span class="block group-peer-checked:hidden">
                                    <x-icons.micro.plus class="size-4" />
                                </span>
                                <span class="hidden group-peer-checked:block">
                                    <x-icons.micro.check class="size-4" />
                                </span>
                                <span>{{ $facet['type']->filterLabel() }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                <noscript>
                    <x-button type="submit" class="mt-4">Chercher</x-button>
                </noscript>
            </form>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-4">
            @foreach ($searchResults as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug->slug) }}" class="flex flex-col max-w-lg w-full">

                    {{ $recipe->getFirstMedia('banner')
                        ?->img()->attributes([
                            'loading' => 'lazy',
                        ]) }}
                    <div class="flex flex-col flex-1">
                        <div class=" border-l border-gray-300 pt-2 pl-4">
                            <h2 class="text-xl font-semibold underline">{{ $recipe->title }}</h2>
                            <p class="text-lg mt-1">{{ $recipe->description }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-frontend-layout>
