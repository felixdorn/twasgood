<x-frontend-layout title="Accueil">
    <x-slot:head>
        <meta name="description" content="Des recettes et des guides pour réduire son empreinte écologique" />
    </x-slot:head>

    <div class="mt-6 lg:mt-8 lg:max-w-7xl mx-auto px-4 lg:px-8 xl:px-0">
        <h1 class="text-4xl lg:text-5xl text-emerald-700 font-bold">
            Des recettes et des guides pour réduire <br class="hidden lg:block"> son empreinte écologique
        </h1>

        <div class="w-full pt-4 pb-8 lg:py-8 space-y-16">
            @foreach ($sections as $section)
                <section>
                    <h2 class="text-2xl lg:text-3xl font-semibold">{{ $section->title }}</h2>
                    <p class="max-w-[65ch] text-gray-900 text-lg mt-1 text-balance">{{ $section->description }}</p>

                    <ul class="flex space-x-6 mt-4 flex-nowrap overflow-x-scroll overflow-y-visible -mb-1 pb-1">
                        @foreach ($section->recipes as $k => $recipe)
                            <li class="flex">
                                <a href="{{ route('recipes.show', $recipe->slug->slug) }}"
                                    class="w-72 lg:w-96 shrink-0 flex flex-col">
                                    {{ $recipe->getFirstMedia('banner')
                                        ?->img()->attributes([
                                            'class' => 'object-top object-cover h-60 w-full bg-gray-100',
                                            'lazy' => $k === 0 ? 'eager' : 'lazy',
                                        ]) }}

                                    <div class="border-l border-gray-300 px-4 pt-2">
                                        <h3 class="text-xl font-medium truncate underline">{{ $recipe->title }}</h3>
                                        <p class="text-gray-700 truncate">{{ $recipe->description }}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endforeach
        </div>
    </div>
</x-frontend-layout>
