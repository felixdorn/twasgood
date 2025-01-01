<x-backend-layout title="Parties">
    <x-slot:header>
        <a href="{{ route('console.sections.create') }}">
            <x-button>Nouvelle partie</x-button>
        </a>
    </x-slot:header>

    <h2 class="text-xl mt-6">Visibles sur la page d'acceuil</h2>
    <div class="mt-2" data-sortable data-sortable-href="{{ route('console.order-sections') }}">
        @foreach ($visible_sections as $section)
            <section class="even:bg-gray-50 first:border-t border-b group" data-sort-value="{{ $section->id }}">
                <div class="flex">
                    <div class="flex flex-col items-center justify-between border-r border-gray-100 py-4 px-2">
                        <div class="flex flex-col items-center">
                            <button type="button" class="p-1 -m-1 hover:bg-gray-200 rounded-lg transition">
                                <x-icons.drag class="size-6" />
                            </button>

                            <form action="{{ route('console.sections.toggle', $section) }}" method="post">
                                @csrf
                                <button type="submit"
                                    class="p-1 -mx-1 mt-2 hover:bg-gray-200 group/toggle rounded-lg transition">
                                    @if (!$section->force_hide)
                                        <x-icons.open-eye
                                            class="size-4 text-brand-600 group-hover/toggle:text-brand-700" />
                                    @else
                                        <x-icons.closed-eye
                                            class="size-4 text-gray-700 group-hover/toggle:text-brand-600" />
                                    @endif
                                </button>
                            </form>
                        </div>

                        <form action="{{ route('console.sections.destroy', $section) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" method="post"
                                onclick="return confirm('Êtes-vous sûr·e de vouloir supprimer cette partie?')"
                                class="mt-4 opacity-0 pointer-events-none group-hover:pointer-events-auto focus:opacity-100 group-hover:opacity-100 transition text-gray-500 hover:text-gray-700 p-1 -mx-1 block -mb-px hover:bg-gray-200 rounded-lg">
                                <x-icons.trash class="size-4" />
                            </button>
                        </form>
                    </div>

                    <x-section-editor :section="$section" :open="$focus === $section->id" class="px-4" />
                </div>
            </section>
        @endforeach
    </div>

    {{-- Used by section editors to add recipes based on their title --}}
    <datalist id="recipes">
        @foreach ($recipes as $recipe)
            <option value="{{ $recipe->title }}"></option>
        @endforeach
    </datalist>
    @vite(['resources/js/pages/section-index.ts'])
</x-backend-layout>
