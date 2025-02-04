<x-backend-layout title="Catégories">
    <div class="bg-gray-50">
        <x-backend-navigation />

        <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8 xl:px-0 w-full flex justify-between items-center">
            <h1 class="text-3xl font-semibold">
                Catégories
            </h1>

            <a href="{{ route('console.categories.create') }}">
                <x-button>Nouvelle catégorie</x-button>
            </a>
        </div>
    </div>



    <div class="max-w-7xl mx-auto mt-6 px-4 lg:px-8 xl:px-0 bg-white">
        <div data-sorter data-sorter-callback="{{ route('console.order-categories') }}">
            @foreach ($categories as $category)
                <section class="odd:bg-gray-50 first:border-t border-b group flex" data-sorter-item="{{ $category->id }}">
                    <div class="flex flex-col items-center justify-between border-r border-gray-100 py-4 px-2">
                        <button type="button" data-sorter-handle
                            class="p-1 -m-1 hover:bg-gray-200 rounded-lg transition">
                            <x-icons.drag class="size-6" />
                        </button>

                    </div>

                    <x-category-editor :category="$category" />
                </section>
            @endforeach
        </div>
    </div>

    <script src="{{ Vite::asset('resources/js/components/sorter.js') }}" type="module" async></script>
    <script src="{{ Vite::asset('resources/js/components/field-autosizing.js') }}" type="module" async></script>
</x-backend-layout>
