<x-backend-layout title="Catégories">
    <x-slot:header>
        <a href="{{ route('console.categories.create') }}">
            <x-button>Nouvelle catégorie</x-button>
        </a>
    </x-slot:header>

    @if (count($categories) > 0)
        <ul class="grid grid-cols-2 xl:grid-cols-3 gap-4 mt-6">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('console.categories.edit', $category) }}"
                        class="group flex flex-col border rounded-xl bg-white py-4 px-6">
                        <span class="text-lg group-hover:underline">{{ $category->name }}</span>
                        <span class="text-gray-500">{{ $category->recipes_count }} au total</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="mt-4 bg-white rounded-xl">
            Aucune catégorie.
        </div>
    @endif
</x-backend-layout>
