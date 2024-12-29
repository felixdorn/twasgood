@props(['title', 'width'])
<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{!! $title !!} - Faire + Acheter -</title>

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
                    <a class="font-bold text-emerald-700 hover:underline whitespace-nowrap text-lg" href="/">
                        <span>Console d'administration</span>
                    </a>
                </div>
                <ul class="w-full flex flex-row-reverse lg:flex-row lg:justify-end items-center space-x-4 lg:space-x-6">
                    <li class="inset-0 relative rounded-xl w-full shadow-sm lg:max-w-md hidden lg:block">
                        <form action="{{ route('search') }}">
                            <input type="search" id="search" name="query" placeholder="Chercher une recette..."
                                autocomplete="off" aria-label="Search"
                                class="block w-full rounded-xl border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600" />
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg id="search-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg id="spinner-icon" aria-hidden="true"
                                    class="hidden size-5 animate-spin text-gray-200 fill-brand-700"
                                    viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                            </div>
                        </form>
                        <div id="search-results" class="relative"></div>
                    </li>
                    <li class="lg:hidden">
                        <a href="{{ route('search') }}">
                            <svg id="search-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="px-4 lg:px-8 bg-gray-50 border-y">
            <div class="flex items-center justify-between text-lg max-w-7xl mx-auto py-2.5">
                <ul class="flex w-full overflow-x-scroll space-x-4 text-white font-semibold">
                    <li>
                        <a href="{{ route('console.recipes.index') }}"
                            class="text-gray-700 whitespace-nowrap hover:underline focus:underline block text-lg">
                            Recettes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.ingredients.index') }}"
                            class="text-gray-700 whitespace-nowrap hover:underline focus:underline block text-lg">
                            Ingredients
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.categories.index') }}"
                            class="text-gray-700 whitespace-nowrap hover:underline focus:underline block text-lg">
                            Catégories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.sections.index') }}"
                            class="text-gray-700 whitespace-nowrap hover:underline focus:underline block text-lg">
                            Parties
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('console.articles.index') }}"
                            class="text-gray-700 whitespace-nowrap hover:underline focus:underline block text-lg">
                            Articles
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <div class="py-6 px-4 lg:px-8">
            <div class="mx-auto {{ $width ?? 'max-w-7xl' }} flex justify-between center">
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
