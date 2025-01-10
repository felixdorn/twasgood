@props(['section', 'recipe', 'open'])
<div {{ $attributes->class('flex flex-col py-4 justify-between') }}>
    <div>
        <form class="relative w-fit" action="{{ route('console.sections.update', $section) }}" method="post">
            @csrf
            @method('PUT')
            <div class="grow-wrap font-bold">
                <input aria-label="Titre de la section" name="title"
                    class=" w-full bg-transparent peer focus:outline-none focus:border-brand-600  focus:ring-0 focus:shadow"
                    value="{{ $section->title }}" />
                <button
                    class="bg-white text-brand-700 border px-2 py-px absolute -right-2 pointer-events-none focus:pointer-events-auto peer-focus:pointer-events-auto translate-x-full focus:outline-none focus:border-brand-600 focus:opacity-100 transition peer-focus:opacity-100 opacity-0">
                    Mettre à jour
                </button>
            </div>
            @error('title', 'section-' . $section->id)
                <p class="text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror
        </form>
        <form action="{{ route('console.sections.update', $section) }}" method="post" class="relative mt-1.5">
            @csrf
            @method('PUT')
            <div class="grow-wrap">
                <textarea name="description" aria-label="Description"
                    class="max-w-[65ch] w-full text-gray-900 focus:outline-none peer focus:border-brand-600 focus:ring-0">{{ $section->description }}</textarea>
                <button
                    class="bg-white w-fit text-brand-700 border px-2 py-px absolute -right-2 translate-x-full whitespace-nowrap pointer-events-none focus:pointer-events-auto peer-focus:pointer-events-auto focus:outline-none focus:border-brand-600 focus:opacity-100 transition peer-focus:opacity-100 opacity-0 font-bold">
                    Mettre à jour
                </button>
            </div>
            @error('description', 'section-' . $section->id)
                <p class="text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror
        </form>
    </div>

    @if (count($section->recipes) > 0)
        <details class="mt-2 group/recipes" @if ($open) open @endif>
            <summary class="list-none">
                <span class="group-open/recipes:hidden underline">Afficher les recettes</span>
                <span class="hidden group-open/recipes:inline-block underline">
                    Cacher les recettes
                </span>
            </summary>
            <ul class="mt-2 grid lg:grid-cols-3 xl:grid-cols-4 sm:grid-cols-3 gap-4" data-sortable
                data-sortable-href="{{ route('console.sections.order', $section) }}">
                @foreach ($section->recipes as $recipe)
                    <li class="w-72 border" data-sort-value="{{ $recipe->id }}">
                        <form method="post"
                            action="{{ route('console.sections.detach', ['section' => $section, 'recipe' => $recipe]) }}"
                            class="relative">
                            @csrf
                            <button type="submit"
                                formaction="{{ route('console.sections.detach', ['section' => $section, 'recipe' => $recipe]) }}"
                                method="post"
                                class="absolute top-0 right-0 bg-white size-8 flex items-center justify-center z-50
                                                block">

                                <x-icons.times class="size-5 text-gray-700" />
                            </button>

                            <img loading="lazy" src="{{ $recipe->banner->small() }}" alt="{{ $recipe->banner->alt }}"
                                class="object-center object-cover w-72 h-36  bg-gray-100" />
                        </form>

                        <h3 class="font-medium truncate p-2 flex">
                            <x-icons.drag class="w-5 h-auto text-gray-700" />
                            <span class="ml-2 ">
                                {{ Str::limit($recipe->title, 32) }}
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
                @error('title', 'section-attach' . $section->id)
                    <p class="text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </details>
    @else
        <div class="w-full">
            <h3 class="font-semibold mt-4">Ajouter une recette</h3>
            <form class="max-w-lg w-full mt-1 flex" action="{{ route('console.sections.attach', $section) }}"
                method="post">
                @csrf
                <x-input class="w-full" aria-label="Titre de la recette" first id="title_{{ $section->id }}"
                    name="title" autocomplete="off" list="recipes"
                    placeholder="Commencez à taper le titre d'une recette..." />
                <x-button class="ml-4">Ajouter</x-button>
            </form>
            @error('title', 'section-attach' . $section->id)
                <p class="text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
    @endif
</div>
