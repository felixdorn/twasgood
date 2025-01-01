@props(['section', 'recipe'])
<div {{ $attributes->class('flex flex-col py-4 justify-between') }}>
    <div>
        <form class="flex">
            @csrf
            <div class="grow-wrap font-bold">
                <input class="pr-2 py-0 pl-0 border-0 font-bold w-full bg-transparent focus:ring-brand-600"
                    value="{{ $section->title }}" />
            </div>
            <button class="bg-white border ml-2 px-2">
                Valider
            </button>
        </form>
        <p class="max-w-[65ch] text-gray-900 mt-1.5">{{ $section->description }}</p>
    </div>

    @if (count($section->recipes) > 0)
        <details class="mt-2 group/recipes">
            <summary class="list-none">
                <span class="group-open/recipes:hidden underline">Afficher les recettes</span>
                <span class="hidden group-open/recipes:inline-block underline">
                    Cacher les recettes
                </span>
            </summary>
            <ul class="mt-2 grid lg:grid-cols-3 xl:grid-cols-4 sm:grid-cols-3 gap-4">
                @foreach ($section->recipes as $recipe)
                    <li class="w-72 border">
                        <div class="relative">
                            <button type="submit"
                                formaction="{{ route('console.sections.detach', ['section' => $section, 'recipe' => $recipe]) }}"
                                method="post"
                                class="absolute top-0 right-0 bg-white size-8 flex items-center justify-center z-50
                                                block">

                                <x-icons.times class="size-5 text-gray-700" />
                            </button>

                            <img loading="lazy" src="{{ $recipe->banner->small() }}" alt="{{ $recipe->banner->alt }}"
                                class="object-center object-cover w-72 h-36  bg-gray-100" />
                        </div>

                        <h3 class="font-medium truncate p-2 flex">
                            <x-icons.drag class="w-5 h-auto text-gray-700" />
                            <span class="ml-2">
                                {{ $recipe->short_title }}
                            </span>
                        </h3>
                    </li>
                @endforeach
            </ul>

            <div>
                <h3 class="font-semibold mt-4">Ajouter une recette</h3>
                <form class="max-w-lg mt-1 flex" action="{{ route('console.sections.attach', $section) }}"
                    method="post">
                    @csrf
                    <x-input aria-label="Titre de la recette" first id="title_{{ $section->id }}" name="title"
                        autocomplete="off" list="recipes" placeholder="Commencez à taper le titre d'une recette..." />
                    <x-button class="ml-4">Ajouter</x-button>
                </form>
                @error('title', 'section-' . $section->id)
                    <p class="text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </details>
    @else
        <div class="text-gray-700 mt-2">
            Aucune recette.
        </div>
    @endif
</div>
