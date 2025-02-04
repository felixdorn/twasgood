<x-backend-layout title="Pages" class="bg-gray-50">
    <div class="flex flex-col w-full h-full">
        <x-backend-navigation />

        <div class="max-w-7xl mx-auto mt-6 px-4 lg:px-8 xl:px-0 w-full">
            <h1 class="text-3xl font-semibold">
                Pages
            </h1>
        </div>

        <div class="flex mt-6">
            <span class="flex-grow border-b w-4 lg:w-8"></span>
            <ul class="flex w-full bg-gray-50 max-w-7xl mx-auto">
                @foreach ($pages as $page)
                    <li>
                        <a href="{{ route('console.pages.index', ['page' => $page['id']]) }}"
                            class="@if ($page['active']) font-semibold text-brand-600 bg-white border border-b-0 @else text-gray-700 border-y border-t-gray-50 @endif px-3 py-1 underline flex items-center">
                            <span>{{ $page['label'] }}</span>
                        </a>
                    </li>
                @endforeach

                <span class="flex-grow border-b"></span>
            </ul>
            <span class="flex-grow border-b w-4 lg:w-8"></span>
        </div>

        <div class="bg-white flex-grow">
            <div class="max-w-7xl mx-auto pt-4 px-4 lg:px-8 xl:px-0 bg-white">
                @if ($currentPage === 'home')
                    <x-page-editors.home />
                @elseif ($currentPage === 'about')
                    <x-page-editors.about />
                @else
                    Invalide.
                @endif
            </div>
        </div>
    </div>

    <script src="{{ Vite::asset('resources/js/components/field-autosizing.js') }}" type="module" async></script>
</x-backend-layout>
