<x-frontend-layout title="Accueil" :noSearch="true">
    <x-slot:head>
        <meta name="description" content="Des recettes et des guides pour réduire son empreinte écologique" />
    </x-slot:head>

    <div class="mt-6 lg:mt-8 lg:max-w-7xl mx-auto px-4 lg:px-8 xl:px-0">
        <h1 class="text-4xl lg:text-5xl text-emerald-700 font-bold">
            Des recettes et des guides pour réduire <br class="hidden lg:block"> son empreinte écologique
        </h1>

        <x-recipe-search class="mt-4" action="{{ route('search') }}" />

        {{-- <section class="mt-6 w-full">
            <h2 class="text-2xl lg:text-3xl font-semibold">Catégories</h2>
            <ul class="flex space-x-6 mt-4 flex-nowrap overflow-x-auto overflow-y-visible -mb-1 pb-1">
                @foreach ($categories as $category)
                    <li class="block border">
                        <h3 class="text-xl  whitespace-nowrap font-semibold">{{ $category->name }} : {{ $category->subtitle }}</h3>
                        <p class="text-lg">{{ $category->description }}</p>

                        <a class="underline text-brand-600 mt-2">Explorer {{ $category->recipes_count }}
                            {{ Str::plural('recette', $category->recipes_count) }}</a>
                    </li>
                @endforeach
            </ul>
        </section>
        --}}

        <div class="w-full pt-4 pb-8 lg:py-8 space-y-16">
            @foreach ($sections as $section)
                <section>
                    <h2 class="text-2xl lg:text-3xl font-semibold">{{ $section->title }}</h2>
                    <p class="max-w-[65ch] text-gray-900 text-lg mt-1 text-balance">{{ $section->description }}</p>

                    <ul class="flex space-x-6 mt-4 flex-nowrap overflow-x-scroll overflow-y-visible -mb-1 pb-1">
                        @foreach ($section->recipes as $recipe)
                            <li class="flex">
                                <x-recipe-card :recipe="$recipe" :excerpt-only="true" :href="route('recipes.show', $recipe->slug->slug)"
                                    class="w-72 lg:w-96" />
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endforeach
        </div>
    </div>
</x-frontend-layout>
