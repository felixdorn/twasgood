    <x-backend-layout title="Mettre à jour un ingrédient" width="max-w-2xl">
        <form action="{{ route('console.ingredients.update', $ingredient) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mt-4">
                <x-input-label>Type</x-input-label>
                <div class="space-y-2 mt-0.5">
                    @foreach (\App\Enums\IngredientType::cases() as $type)
                        <div class="flex items-center">
                            <input id="{{ $type->name }}" value="{{ $type->value }}" name="type" type="radio"
                                @if ($type->value === $ingredient->type->value) checked @endif
                                class="checked:bg-brand-600 focus:ring-brand-500 border-gray-300 focus:checked:bg-brand-600 checked:hover:bg-brand-700">
                            <label for="{{ $type->name }}" class="ml-2 block">{{ $type->label() }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <x-input-error name="type" />

            <div class="mt-4">
                <x-input-label for="name">Nom</x-input-label>
                <x-input value="{{ $ingredient->name }}" name="name" placeholder="Cacao" type="text"
                    class="mt-0.5" />
                <x-input-error name="name" />
            </div>

            <fieldset class="space-y-5">
                <legend class="sr-only">Allergènes</legend>
                <div class="flex relative items-start">
                    <div class="flex items-center h-5">
                        <input id="gluten" aria-describedby="gluten-description"
                            class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                            @if ($ingredient->contains_gluten) checked @endif name="contains_gluten" type="checkbox" />
                    </div>
                    <div class="ml-3">
                        <label class="font-medium text-gray-700 -mt-0.5 block" for="gluten">Contient du gluten</label>
                        <p id="gluten-description" class="text-gray-500">
                            Le gluten est un mélange de protéines contenues dans
                            le blé, le seigle, l'orge et l'avoine.
                        </p>
                    </div>
                </div>
                <div class="flex relative items-start">
                    <div class="flex items-center h-5">
                        <input id="dairy" aria-describedby="dairy-description"
                            @if ($ingredient->contains_dairy) checked @endif
                            class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                            name="contains_dairy" type="checkbox" />
                    </div>
                    <div class="ml-3">
                        <label class="font-medium text-gray-700 -mt-0.5 block" for="dairy">Contient du
                            lactose</label>
                        <p id="dairy-description" class="text-gray-500">
                            Le lactose est un sucre naturellement présent dans
                            le lait et les produits laitiers.
                        </p>
                    </div>
                </div>
            </fieldset>

            <x-button class="mt-6" type="submit">
                Mettre à jour
            </x-button>
        </form>
    </x-backend-layout>
