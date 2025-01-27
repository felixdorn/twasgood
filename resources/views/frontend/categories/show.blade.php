<x-frontend-layout title="{{ $category->name }}{{ $category->subtitle ? ': ' . $category->subtitle : '' }}">
    <div class="w-full py-8 max-w-7xl px-8 xl:px-0  mx-auto">
        <h1 class="font-semibold w-fit text-4xl">{{ $category->name }}
            <span v-if="category.subtitle">: {{ $category->subtitle }}</span>
        </h1>

        <p v-if="category.description" class="max-w-prose text-lg text-gray-700 mt-3 text-balance">
            {{ $category->description }}</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-4">
            @foreach ($category->recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug->slug) }}" class="flex flex-col max-w-lg w-full">
                    {{ $recipe->getFirstMedia('banner')?->img()->attributes([
                        'loading' => 'lazy'
                    ]) }}
                    <div class="flex flex-col flex-1 border-l border-gray-300 pt-2 pl-4">
                        <h2 class="text-xl font-semibold underline">{{ $recipe->title }}</h2>
                        <p class="text-lg mt-1">{{ $recipe->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-frontend-layout>
