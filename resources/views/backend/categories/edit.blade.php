<x-backend-layout title="Éditer la catégorie" width="max-w-2xl">
    <form action="{{ route('console.categories.update', $category) }}" method="post">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name">Nom</x-input-label>
            <x-input class="mt-0.5" name="name" placeholder="Miam" type="text" value="{{ $category->name }}" />
            <x-input-error name="name" />
        </div>


        <div class="mt-4">
            <x-input-label name="subtitle">Sous-titre</x-input-label>
            <x-input name="subtitle" placeholder="c'est vraiment bon!" type="text"
                value="{{ $category->subtitle }}" />
            <x-input-error name="subtitle" />
        </div>

        <div class="mt-4">
            <x-input-label name="description">Description</x-input-label>
            <x-input name="description" placeholder="Description" type="text" value="{{ $category->description }}" />
            <x-input-error name="description" />
        </div>

        <div class="flex items-center space-x-2 mt-4">
            <x-checkbox type="checkbox" name="hidden" :checked="$category->hidden" />
            <x-input-label for="hidden">Cacher pour les visiteurs</x-input-label>
        </div>
        <x-input-error name="hidden" />

        <x-button class="mt-6" type="submit">
            Mettre à jour
        </x-button>
    </form>
</x-backend-layout>
