@props(['section', 'recipe', 'open'])
<div {{ $attributes->class('flex flex-col py-4 justify-between w-full') }}>
    <form class="w-full" action="{{ route('console.sections.update', $section) }}" method="post">
        @csrf
        @method('PUT')
        <input aria-label="Titre de la section" name="title" data-field-autosizing
            class="w-full border-gray-300 peer focus:outline-hidden focus:border-brand-600  focus:ring-0 focus:shadow-sm max-w-2xl min-w-xs font-bold text-lg"
            value="{{ $section->title }}" />

        @error('title', 'section-' . $section->id)
            <p class="text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

        <textarea name="description" aria-label="Desription" data-field-autosizing
            class="block max-w-[65ch] transition border-gray-300 w-full focus:outline-hidden peer focus:border-brand-600 focus:ring-0">{{ $section->description }}</textarea>

        @error('description', 'section-' . $section->id)
            <p class="text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

        <x-buttons.secondary class="block mt-2">Mettre à jour</x-buttons.secondary>
    </form>

    @if (count($section->recipes) > 0)
        <details class="mt-4 group/recipes" @if ($open) open @endif>
            <summary class="list-none">
                <span class="group-open/recipes:hidden underline">Afficher les recettes</span>
                <span class="hidden group-open/recipes:inline-block underline">
                    Cacher les recettes
                </span>
            </summary>
            <ul class="mt-2 grid lg:grid-cols-3 xl:grid-cols-4 sm:grid-cols-3 gap-4" data-sorter
                data-sorter-callback="{{ route('console.sections.order-recipes', $section) }}">
                @foreach ($section->recipes as $recipe)
                    <li class="w-72 border" data-sorter-item="{{ $recipe->id }}">
                        <form method="post"
                            action="{{ route('console.sections.detach', ['section' => $section, 'recipe' => $recipe]) }}"
                            class="relative">
                            @csrf
                            <button type="submit"
                                formaction="{{ route('console.sections.detach', ['section' => $section, 'recipe' => $recipe]) }}"
                                method="post"
                                class="absolute top-0 right-0 bg-white size-8 flex items-center justify-center z-50 block">

                                <x-icons.times class="size-5 text-gray-700" />
                            </button>

                            {{ $recipe->getFirstMedia('banner')
                                ?->img('thumb')->attributes([
                                    'loading' => 'lazy',
                                    'class' => 'object-center object-cover w-72 h-36 bg-gray-100',
                                ]) }}
                        </form>

                        <h3 class="font-medium truncate p-2 flex bg-white">
                            <button data-sorter-handle>
                                <x-icons.drag class="w-5 h-auto" />
                            </button>
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
                        autocomplete="off" list="recipes-datalist"
                        placeholder="Commencez à taper le titre d'une recette..." />
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
                    name="title" autocomplete="off" list="recipes-datalist"
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
