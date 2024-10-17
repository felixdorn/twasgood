<x-layouts.default title="Accueil">
    <x-slot:head>
        <meta name="description" content="Des recettes et des guides pour réduire son empreinte écologique"/>
    </x-slot:head>

    <div class="mt-8 lg:max-w-7xl mx-auto px-8 xl:px-0">
        <h1 class="text-4xl lg:text-5xl text-black font-bold leading-snug">
            Des recettes et des guides pour réduire <br class="hidden lg:block"> son empreinte écologique
        </h1>

        <div class="w-full py-8 space-y-16">
            @foreach ($sections as $section)
            <section>
                <h2 class="text-3xl font-semibold">{{ $section->title }}</h2>
                <p class="max-w-[65ch] text-gray-900 text-lg mt-1">{{ $section->description }}</p>

                <ul class="flex space-x-6 mt-4 flex-nowrap overflow-x-scroll overflow-y-visible -mb-1 pb-1">
                    @foreach ($section->recipes as $k => $recipe)
                    <li class="flex shadow-md rounded-xl">
                        <a href="{{ route('recipes.show', $recipe->slug->slug) }}"
                            class="w-72 lg:w-96 flex-shrink-0 flex flex-col">
                            <img
                                loading="{{ $k === 0 ? 'eager' : 'lazy' }}"
                                src="{{ $recipe->banner->small() }}" alt="{{ $recipe->banner->alt }}"
                                class="object-top object-cover rounded-t-xl h-60 w-full bg-gray-100"/>

                            <div class="p-4 bg-white rounded-b-xl">
                                <h3 class="text-xl font-medium truncate">{{ $recipe->short_title }}</h3>
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
</x-layouts.default>
