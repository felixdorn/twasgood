<x-backend-layout title="Parties">
    <x-slot:header>
        <a :href="route('console.sections.create')">
            <x-button>Nouvelle partie</x-button>
        </a>
    </x-slot:header>

    <div class="mt-2">
        @foreach ($sections as $group)
            @foreach ($group as $section)
                <section class="flex space-x-4 even:bg-gray-50 py-4 border-x odd:border-t even:border-t px-4">
                    <svg class="-ml-1.5 size-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm1.5 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm1.5 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm-1.5 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>
                    <div class="flex flex-col">
                        <div class="flex items-center space-x-2">
                            <button class="p-1 -m-1 hover:bg-gray-100 group rounded-lg transition">
                                @if (!$section->force_hide)
                                    <svg class="size-4 text-brand-600 group-hover:text-brand-700"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M1.2 12a11 11 0 0 1 21.6 0 11 11 0 0 1-21.6 0ZM12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                                    </svg>
                                @else
                                    <svg class="size-4 text-gray-700 group-hover:text-brand-600"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M4.5 6 1.4 2.7l1.4-1.4 19.8 19.8-1.4 1.4-3.3-3.3A11 11 0 0 1 1.2 12a11 11 0 0 1 3.3-6Zm10.3 10.2-1.5-1.5a3 3 0 0 1-4-4L7.8 9.2a5 5 0 0 0 7 7ZM8 3.8A11 11 0 0 1 22.8 12a11 11 0 0 1-2 4.6L17 12.7l.1-.7a5 5 0 0 0-5.7-5L8 3.9Z" />
                                    </svg>
                                @endif
                            </button>
                            <h3
                                class="text-xl font-bold bg-transparent border-none shadow-none leading-none p-0 rounded-md inline-block">
                                {{ $section->title }}</h3>
                        </div>
                        <p class="max-w-[65ch] text-gray-900 mt-1">{{ $section->description }}</p>

                        <details class="mt-2 group">
                            <summary class="list-none">
                                <span class="group-open:hidden underline">Afficher les recettes</span>
                                <span class="hidden group-open:inline-block underline">Cacher les recettes</span>
                            </summary>
                            <ul class="mt-2 grid lg:grid-cols-3 xl:grid-cols-4 sm:grid-cols-3 gap-4">
                                @foreach ($section->recipes as $recipe)
                                    <li class="w-72 border">
                                        <div class="relative">
                                            <span
                                                class="absolute top-0 right-0 bg-white size-8 flex items-center justify-center z-50 block">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    class="size-5 text-gray-700" viewBox="0 0 24 24">
                                                    <path
                                                        d="m12 10.6 5-5 1.4 1.5-5 4.9 5 5-1.5 1.4-4.9-5-5 5L5.6 17l5-5-5-5L7 5.7l5 5Z" />
                                                </svg>
                                            </span>

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
                    </div>
                </section>
            @endforeach
        @endforeach
    </div>
</x-backend-layout>
