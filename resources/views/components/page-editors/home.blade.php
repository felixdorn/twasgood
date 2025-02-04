<div class="flex justify-between items-center">
    <h2 class="text-2xl font-semibold">Rubriques</h2>
    <a href="{{ route('console.sections.create') }}">
        <x-button>Nouvelle rubrique</x-button>
    </a>
</div>

@if (count($visible_sections) === 0 && count($hidden_sections) === 0)
    <div class="border py-4 px-6 bg-gray-50 mt-2 flex flex-col ">
        <h2 class="text-2xl font-semibold">Créez votre première rubrique.</h2>
        <p class="text-lg mt-1 text-gray-700">Aucune rubrique n'existe pour l'instant, commencez par en créer une.</p>

        <a href="{{ route('console.sections.create') }}" class="mt-4">
            <x-button>Créer</x-button>
        </a>
    </div>
@endif

@if (count($visible_sections) > 0)
    <div class="mt-4" data-sorter data-sorter-callback="{{ route('console.order-sections') }}">
        @foreach ($visible_sections as $section)
            <section class="odd:bg-gray-50 first:border-t border-b group flex" data-sorter-item="{{ $section->id }}">
                <div class="flex flex-col items-center justify-between border-r border-gray-100 py-4 px-2">
                    <div class="flex flex-col items-center">
                        <button type="button" data-sorter-handle
                            class="p-1 -m-1 hover:bg-gray-200 rounded-lg transition">
                            <x-icons.drag class="size-6" />
                        </button>

                        <form action="{{ route('console.sections.toggle', $section) }}" method="post">
                            @csrf
                            <button type="submit"
                                class="p-1 -mx-1 mt-2 hover:bg-gray-200 group/toggle rounded-lg transition">
                                @if ($section->hidden_at === null)
                                    <x-icons.open-eye class="size-4 text-brand-600 group-hover/toggle:text-brand-700" />
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

                <x-section-editor :section="$section" :open="session('focus') === $section->id" class="px-4" />
            </section>
        @endforeach
    </div>
@endif


@if (count($hidden_sections) > 0)
    <h2 class="text-xl font-semibold mt-6">Rubriques cachées</h2>
    <div class="mt-2">
        @foreach ($hidden_sections as $section)
            <section class="odd:bg-gray-50 first:border-t border-b group flex">
                <div class="flex flex-col items-center justify-between border-r border-gray-100 py-4 px-2">
                    <div class="flex flex-col items-center px-1">
                        <form action="{{ route('console.sections.toggle', $section) }}" method="post">
                            @csrf
                            <button type="submit"
                                class="p-1 -mx-1  hover:bg-gray-200 group/toggle rounded-lg transition">
                                @if ($section->hidden_at === null)
                                    <x-icons.open-eye class="size-4 text-brand-600 group-hover/toggle:text-brand-700" />
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

                <x-section-editor :section="$section" :open="session('focus') === $section->id" class="px-4" />
            </section>
        @endforeach
    </div>
@endif

{{-- Used by section editors to add recipes based on their title --}}
<datalist id="recipes-datalist">
    @foreach ($recipes as $recipe)
        <option value="{{ $recipe->title }}"></option>
    @endforeach
</datalist>

<script src="{{ Vite::asset('resources/js/components/sorter.js') }}" type="module" async></script>
