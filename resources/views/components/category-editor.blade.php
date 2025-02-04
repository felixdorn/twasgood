@props(['category'])
<div {{ $attributes->class('p-4 w-full') }}>
    <form class="w-full" action="{{ route('console.categories.update', $category) }}" method="post">
        @csrf
        @method('PUT')

        <div>
            <input name="name" data-field-autosizing class="font-bold text-lg border-gray-300 max-w-3xs"
                value="{{ $category->name }}" />
            <span class="text-xl"> &mdash; </span>
            <input name="subtitle" data-field-autosizing class="text-lg border-gray-200 max-w-lg"
                value="{{ $category->subtitle }}" />
        </div>

        <div class="mt-4">
            <label for="description" class="font-semibold">Description</label>
            <textarea name="description" id="description" data-field-autosizing
                class="block mt-0.5 w-full max-w-prose border-gray-200">{{ $category->description }}</textarea>
        </div>

        <x-buttons.secondary class="block mt-2">Mettre à jour</x-buttons>

            <p class="mt-2">
                {{ $category->recipes_count }} {{ Str::plural('recette', $category->recipes_count) }} appartiennent à
                cette
                catégorie.
            </p>
    </form>
</div>
