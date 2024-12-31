<x-backend-layout title="Parties">
    <x-slot:header>
        <a href="{{ route('console.sections.create') }}">
            <x-button>Nouvelle partie</x-button>
        </a>
    </x-slot:header>

    <div class="mt-2">
        @foreach ($sections as $group)
            @foreach ($group as $section)
                <section class="flex space-x-4 even:bg-gray-50 odd:border-t even:border-t group">
                    <div class="flex flex-col items-center justify-between border-r border-gray-100 py-4 px-2">
                        <div class="flex flex-col items-center">
                            <button class="p-1 -m-1 hover:bg-gray-200 rounded-lg transition">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M8.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm1.5 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm1.5 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm-1.5 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                </svg>
                            </button>
                            <form action="{{ route('console.sections.toggle', $section) }}" method="post"
                                class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="p-1 -m-1 hover:bg-gray-200 group/toggle rounded-lg transition">
                                    @if (!$section->force_hide)
                                        <svg class="size-4 text-brand-600 group-hover/toggle:text-brand-700"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M1.2 12a11 11 0 0 1 21.6 0 11 11 0 0 1-21.6 0ZM12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                                        </svg>
                                    @else
                                        <svg class="size-4 text-gray-700 group-hover/toggle:text-brand-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4.5 6 1.4 2.7l1.4-1.4 19.8 19.8-1.4 1.4-3.3-3.3A11 11 0 0 1 1.2 12a11 11 0 0 1 3.3-6Zm10.3 10.2-1.5-1.5a3 3 0 0 1-4-4L7.8 9.2a5 5 0 0 0 7 7ZM8 3.8A11 11 0 0 1 22.8 12a11 11 0 0 1-2 4.6L17 12.7l.1-.7a5 5 0 0 0-5.7-5L8 3.9Z" />
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>

                        <form action="{{ route('console.sections.destroy', $section) }}" method="post" class="mt-6">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Êtes-vous sûr·e de vouloir supprimer cette partie?')"
                                class="opacity-0 pointer-events-none group-hover:pointer-events-auto focus:opacity-100 group-hover:opacity-100 transition text-gray-500 hover:text-gray-700 p-1 -mx-1 -mb-0.5 block hover:bg-gray-200 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-4"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.8 1A2.8 2.8 0 0 0 6 3.8v.4l-2.4.3A.8.8 0 1 0 4 6l1 10.5A2.8 2.8 0 0 0 7.6 19h4.8a2.8 2.8 0 0 0 2.7-2.5L16 5.9h.1a.8.8 0 0 0 .3-1.4 41 41 0 0 0-2.4-.3v-.5A2.8 2.8 0 0 0 11.2 1H8.8ZM10 4h2.5v-.3c0-.6-.6-1.2-1.3-1.2H8.8c-.7 0-1.3.6-1.3 1.3V4H10ZM8.6 7.7a.8.8 0 0 0-1.5 0l.3 7.6a.8.8 0 1 0 1.5 0l-.3-7.6Zm4.3 0a.8.8 0 1 0-1.5 0l-.3 7.5a.8.8 0 1 0 1.5 0l.3-7.4Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="flex flex-col py-4 justify-between">
                        <div>
                            <h3
                                class="text-xl font-bold bg-transparent border-none shadow-none leading-none p-0 rounded-md inline-block">
                                {{ $section->title }}</h3>
                            <p class="max-w-[65ch] text-gray-900 mt-1.5">{{ $section->description }}</p>
                        </div>

                        @if (count($section->recipes) > 0)
                            <details class="mt-2 group/recipes" @if ($focus === $section->id) open @endif>
                                <summary class="list-none">
                                    <span class="group-open/recipes:hidden underline">Afficher les recettes</span>
                                    <span class="hidden group-open/recipes:inline-block underline">Cacher les
                                        recettes</span>
                                </summary>
                                <ul class="mt-2 grid lg:grid-cols-3 xl:grid-cols-4 sm:grid-cols-3 gap-4">
                                    @foreach ($section->recipes as $recipe)
                                        <li class="w-72 border">
                                            <div class="relative">
                                                <form
                                                    action="{{ route('console.sections.detach', ['section' => $section, 'recipe' => $recipe]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit"
                                                        class="absolute
                                                top-0 right-0 bg-white size-8 flex items-center justify-center z-50
                                                block">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            class="size-5 text-gray-700" viewBox="0 0 24 24">
                                                            <path
                                                                d="m12 10.6 5-5 1.4 1.5-5 4.9 5 5-1.5 1.4-4.9-5-5 5L5.6 17l5-5-5-5L7 5.7l5 5Z" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <img loading="lazy" src="{{ $recipe->banner->small() }}"
                                                    alt="{{ $recipe->banner->alt }}"
                                                    class="object-center object-cover w-72 h-36  bg-gray-100" />
                                            </div>

                                            <h3 class="font-medium truncate p-2 flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24" class="w-5 h-auto text-gray-800">
                                                    <path
                                                        d="M8.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm1.5 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm1.5 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm-1.5 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                                </svg>
                                                <span class="ml-2">
                                                    {{ $recipe->short_title }}
                                                </span>
                                            </h3>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @else
                            <div class="text-gray-700 mt-2">
                                Aucune recette.
                            </div>
                        @endif
                    </div>
                </section>
            @endforeach
        @endforeach
    </div>
</x-backend-layout>
