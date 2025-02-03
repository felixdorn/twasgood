<form {{ $attributes }}>
    @if ($old?->query['category'] !== null)
        <input type="hidden" name="category" value="{{ $old->query['category'] }}" />
    @endif

    <div class="flex">
        <div>
            <select name="occasion" class="border-gray-300 border-r-0">
                @foreach (\App\Enums\RecipeType::cases() as $recipeType)
                    <option value="{{ $recipeType->value }}" @if ($recipeType->shouldBeSelected($old?->query['occasion'])) selected @endif>
                        {{ $recipeType->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <x-input name="q" placeholder="Chercher une recette..." autocomplete="off"
            value="{{ $old?->query['query'] ?? '' }}" />
        <x-input-error name="q" />
    </div>

    @if (count($facets) > 0)
        <div>
            <div class="flex space-x-2 lg:space-x-4 flex-nowrap mt-2 py-1 overflow-x-scroll">
                @foreach ($facets as $facet)
                    <div class="flex items-center">
                        <input type="checkbox" name="{{ $facet['op'] }}[]" value="{{ $facet['label']->value }}"
                            @if ($facet['active']) checked @endif id="{{ $facet['label']->name }}"
                            class="sr-only peer" />
                        <label for="{{ $facet['label']->name }}"
                            class="group peer-checked:bg-brand-600 flex bg-gray-50 items-center border px-2 py-0.5 peer-checked:text-white transition peer-checked:border-brand-600 peer-focus:ring! peer-focus:ring-offset-2 peer-focus:">
                            <span class="block group-peer-checked:hidden text-gray-500">
                                <x-icons.micro.plus class="size-4" />
                            </span>
                            <span class="hidden group-peer-checked:block">
                                <x-icons.micro.check class="size-4" />
                            </span>
                            <span class="ml-1 select-none whitespace-nowrap">{{ $facet['label']->filterLabel() }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <x-button type="submit" class="mt-2">Chercher</x-button>
</form>
