<x-frontend-layout title="{{ $recipe->title }} - {{ $recipe->category->name }}">
    <x-slot:head>
        <meta content="{{ $recipe->getFirstMediaUrl('banner') }}" property="og:image" />
        <meta content="{{ $recipe->title }}" property="og:title" />
        <meta content="{{ $recipe->description }}" property="og:description" />
        <meta content="article" property="og:type" />

        <meta content="summary_large_image" property="twitter:card">
        <meta content="{{ $recipe->title }}" property="twitter:title">
        <meta content="{{ $recipe->description }}" property="twitter:description">
        <meta :content="{{ $recipe->getFirstMediaUrl('banner') }}" property="twitter:image">

        <meta content="{{ $recipe->description }}" name="description" />
    </x-slot:head>

    <div class="mt-8 lg:mt-8 lg:max-w-7xl mx-auto px-4 lg:px-8 xl:px-0">
        <div>
            {{ $recipe->getFirstMedia('banner') }}

            <h1 class="font-semibold text-3xl lg:text-6xl mt-6 lg:mt-12 text-center">
                {{ $recipe->title }}
            </h1>

            <p class="max-w-prose mx-auto text-balance  text-center text-xl text-gray-800 lg:text-2xl mt-2 lg:mt-6">
                {{ $recipe->description }}</p>

        </div>

    </div>

    <div class="mt-8 lg:mt-16 lg:max-w-7xl mx-auto px-4 lg:px-8 xl:px-0 flex flex-col lg:flex-row justify-center">
        <aside class="lg:mr-24 pb-2 max-w-sm">
            <h2 class="text-xl lg:text-2xl font-semibold text-brand-700">
                Ingrédients
            </h2>

            <ul class="mt-0.5">
                @foreach ($recipe->prerequisites as $k => $prerequisite)
                    <li class="py-1.5">
                        <div>
                            <span class="font-semibold text-lg">
                                {{ $prerequisite->prerequisite->title ?? $prerequisite->prerequisite->name }}

                                @if ($prerequisite->details)
                                    <span class="font-normal">
                                        ({{ $prerequisite->details }})
                                    </span>
                                @endif

                            </span>
                            @if ($prerequisite->optional)
                                <div class="mt-1 ml-2">
                                    <span
                                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Optionel</span>
                                </div>
                            @endif
                            <span class="block mt-1 text-lg ml-2">
                                {{ $prerequisite->quantity }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>

            @if (count($recipe->illustrations) > 0)
                <h2 class="text-xl lg:text-2xl font-semibold text-brand-700 mt-8">Illustrations</h2>
                <ul class="divide-y hidden lg:block mt-1.5">
                    @foreach ($recipe->illustrations as $illustration)
                        <li class="mt-8 first:mt-0">
                            {{ $illustration->img()->attributes([
                                'loading' => 'lazy',
                                'class' => 'object-cover object-center',
                            ]) }}
                            @if (!empty($illustration->getCustomProperty('caption')))
                                <span class="block border-l border-gray-200 pl-2.5 pt-1">
                                    {{ $illustration->getCustomProperty('caption') }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </aside>
        <div class="max-w-prose w-full mt-4 lg:mt-0">
            <h2>
                <span class="text-xl lg:text-2xl font-semibold text-brand-700">
                    Préparation
                </span>
                <span class="text-xl lg:text-2xl font-semibold text-gray-700">({{ $recipe->time_to_prepare }})</span>
            </h2>

            @if ($recipe->uses_sterilization)
                <div class="mt-1.5
                    mb-3 bg-amber-50 px-2 py-1">
                    <span class="font-bold text-lg text-amber-900 block">
                        Avertissement : cette recette nécessite de la stérilisation
                    </span>

                    <a href="{{ route('sterilization-warning') }}"
                        class="block text-amber-900 font-medium underline text-lg">
                        Comment bien stériliser ses bocaux &rarr;
                    </a>
                </div>
            @endif

            <div class="prose prose-xl prose-emerald prose-p:text-gray-900">
                {{ $recipe->html }}
            </div>

            <div class="not-prose border-t my-8 pt-8">
                <x-author-spotlight :author="$recipe->author" />
            </div>
        </div>
    </div>
</x-frontend-layout>
