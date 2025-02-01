<x-frontend-layout title="{{ $category->name }}{{ $category->subtitle ? ': ' . $category->subtitle : '' }}">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">{{ $category->name }}
            <span>: {{ $category->subtitle }}</span>
        </h1>

        <p class="max-w-prose text-lg text-gray-700 mt-3 text-balance">{{ $category->description }}</p>

        <div class="mt-8">
            <h3 class="text-lg font-semibold">Filtrer les recettes</h3>
            <form class="mt-2">
                <div class="flex">
                    <div>
                        <select name="occasion" class="border-gray-300 border-r-0">
                            @foreach (\App\Enums\RecipeType::cases() as $recipeType)
                                <option value="{{ $recipeType->value }}"
                                    @if ($occasion === null && $recipeType === \App\Enums\RecipeType::ForAllOccasions) selected
                                    @elseif ($occasion !== null && $recipeType->value === $occasion) selected @endif>
                                    {{ $recipeType->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input name="q" placeholder="Chercher une recette..." autocomplete="off"
                        value="{{ $query }}" />
                    <x-input-error name="q" />
                </div>

                <div>
                    <div class="flex space-x-1 lg:space-x-4 flex-nowrap mt-2 py-1 ">
                        @foreach ($facets as $facet)
                            <div class="flex items-center">
                                <input type="checkbox" name="{{ $facet['op'] }}[]" value="{{ $facet['label']->value }}"
                                    @if ($facet['active']) checked @endif id="{{ $facet['label']->name }}"
                                    class="sr-only peer" />
                                <label for="{{ $facet['label']->name }}"
                                    class="group peer-checked:bg-brand-600 flex bg-gray-50 items-center border px-2 py-0.5 peer-checked:text-white transition peer-checked:border-brand-600 peer-focus:ring! peer-focus:ring-offset-2 peer-focus:">
                                    <span class="block group-peer-checked:hidden text-gray-500">
                                        <x-icons.micro.plus class="size-4" />
                                    </span>
                                    <span class="hidden group-peer-checked:block">
                                        <x-icons.micro.check class="size-4" />
                                    </span>
                                    <span
                                        class="ml-1 select-none whitespace-nowrap">{{ $facet['label']->filterLabel() }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-button type="submit" class="mt-2">Chercher</x-button>
            </form>
        </div>

        <div class="relative mt-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white pr-2">{{ $estimatedTotal }}
                    {{ Str::plural('résultat', $estimatedTotal) }} </span>
            </div>
        </div>

        @if (count($searchResults) > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-2">
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
@else
    <p class="text-lg mt-4">Aucune recette ne correspond à ces filtres.</p>
    @endif
</x-frontend-layout>
