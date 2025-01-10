@props(['title', 'width'])
<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{!! $title !!} - Faire plus, acheter moins.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jost:400" rel="stylesheet" />

    {{ $head ?? '' }}

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body class="font-sans antialiased h-full">
    <header>
        <nav class="w-full py-3 px-4 lg:px-8">
            <div class="flex items-center justify-between max-w-7xl mx-auto relative">
                <div class="flex items-center space-x-4  w-full lg:border-none border-white/50 ">
                    <a class="font-bold text-emerald-700 underline whitespace-nowrap text-lg" href="/">
                        <span>Backoffice</span>
                    </a>
                </div>
                <ul class="w-full flex flex-row-reverse lg:flex-row lg:justify-end items-center space-x-4 lg:space-x-6">
                    <li class="inset-0 relative rounded-xl w-full shadow-sm lg:max-w-md hidden lg:block">
                        <form action="{{ route('search') }}">
                            <input type="search" id="search" name="query" placeholder="Chercher une recette..."
                                autocomplete="off" aria-label="Search"
                                class="block w-full rounded-xl border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600" />
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">

                                <x-icons.search id="search-icon" aria-hidden="true" class="size-5 text-gray-400" />
                                <x-icons.spinner id="spinner-icon" aria-hidden="true"
                                    class="hidden size-5 animate-spin text-gray-200 fill-brand-700" />
                            </div>
                        </form>
                        <div id="search-results" class="relative"></div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="px-4 lg:px-8 bg-gray-50 border-y">
            <div class="flex items-center justify-between text-lg max-w-7xl mx-auto py-2.5">
                <ul class="flex w-full overflow-x-scroll space-x-4 text-white font-semibold">
                    <li>
                        <a href="{{ route('console.recipes.index') }}"
                            class="text-gray-700 whitespace-nowrap underline block text-lg">
                            Recettes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.ingredients.index') }}"
                            class="text-gray-700 whitespace-nowrap underline block text-lg">
                            Ingredients
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.categories.index') }}"
                            class="text-gray-700 whitespace-nowrap underline block text-lg">
                            Catégories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.sections.index') }}"
                            class="text-gray-700 whitespace-nowrap underline block text-lg">
                            Parties
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <div class="py-6 px-4 lg:px-8">
            <div class="mx-auto {{ $width ?? 'max-w-7xl' }} flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ $title }}
                </h1>

                {{ $header ?? '' }}
            </div>
            <div class="mx-auto {{ $width ?? 'max-w-7xl' }}">
                {{ $slot }}
            </div>
        </div>
    </main>
</body>

</html>
