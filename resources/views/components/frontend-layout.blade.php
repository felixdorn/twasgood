@props(['title'])
<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{!! $title !!} - Faire plus, acheter moins.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jost:400" rel="stylesheet" />

    {{ $head ?? '' }}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full">
    <header>
        <nav class="w-full pt-4 lg:pb-4 px-4 lg:px-8 text-lg xl:text-xl">
            <div class=" max-w-7xl mx-auto relative">
                <ul class="w-full grid grid-cols-2 lg:flex lg:space-x-6 items-center">
                    <li class="flex-1">

                        <a class="underline whitespace-nowrap" href="/">
                            <span class="font-bold text-brand-700 underline">Faire + Acheter -</span>
                        </a>
                    </li>
                    <li class="order-last lg:order-none col-span-full lg:col-span-1 mt-4 lg:mt-0 lg:w-full lg:max-w-md">
                        <form action="{{ route('search') }}" class="inset-0 relative rounded-xl w-full shadow-xs">
                            <input type="search" id="search" name="query" placeholder="Checher une recette..."
                                autocomplete="off" aria-label="Search"
                                class="block w-full border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600" />
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">

                                <x-icons.search id="search-icon" aria-hidden="true" class="size-5 text-gray-400" />
                                <x-icons.spinner id="spinner-icon" aria-hidden="true"
                                    class="hidden size-5 animate-spin text-gray-200 fill-brand-700" />
                            </div>
                        </form>
                        <div id="search-results" class="relative"></div>
                    </li>
                    <li class="text-right lg:w-fit lg:order-last">
                        <a href="{{ route('about-us') }}" class="whitespace-nowrap underline">À propos</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="px-4 lg:px-8 lg:bg-gray-50 lg:border-y">
            <div class="flex items-center justify-between max-w-7xl mx-auto pt-2 lg:py-2.5">
                <ul class="flex w-full overflow-x-scroll space-x-4 text-white font-semibold">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', ['category' => $category->slug->slug]) }}"
                                class="text-gray-700 whitespace-nowrap underline  block lg:text-lg">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
    {{ $slot }}
    <footer class="border-t bg-white px-8 lg:mt-8">
        <div class="max-w-7xl mx-auto">
            <div class="py-6 lg:flex lg:justify-between">
                <div class="flex justify-between flex-col">
                    <h3 class="text-xl text-brand-600 font-bold underline"><a href="{{ route('welcome') }}">Faire +
                            Acheter -</a></h3>
                    <p class="text-gray-700 font-black">
                        Des recettes et des guides pour réduire son empreinte écologique.
                    </p>
                </div>
                <ul class="flex  space-x-4  lg:space-x-0 lg:block items-center lg:space-y-3 mt-4 lg:mt-0">
                    <li>
                        <a class="flex underline items-center text-[#0865ff]"
                            href="https://www.facebook.com/faireplusachetermoins" rel="noreferrer noopener nofollow"
                            target="_blank">
                            <svg aria-hidden="true" class="size-6" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.001 19.9381C16.9473 19.446 20.001 16.0796 20.001 12C20.001 7.58172 16.4193 4 12.001 4C7.5827 4 4.00098 7.58172 4.00098 12C4.00098 16.0796 7.05467 19.446 11.001 19.9381V14H9.00098V12H11.001V10.3458C11.001 9.00855 11.1402 8.52362 11.4017 8.03473C11.6631 7.54584 12.0468 7.16216 12.5357 6.9007C12.9184 6.69604 13.3931 6.57252 14.2227 6.51954C14.5519 6.49851 14.9781 6.52533 15.501 6.6V8.5H15.001C14.0837 8.5 13.7052 8.54332 13.4789 8.66433C13.3386 8.73939 13.2404 8.83758 13.1653 8.97793C13.0443 9.20418 13.001 9.42853 13.001 10.3458V12H15.501L15.001 14H13.001V19.9381ZM12.001 22C6.47813 22 2.00098 17.5228 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="ml-1.5 underline">Facebook</span>
                        </a>
                    </li>
                    <li>
                        <a class="underline flex items-center text-[#e7476b]"
                            href="https://www.instagram.com/faireplusachetermoins/" rel="noreferrer noopener nofollow"
                            target="_blank">
                            <svg aria-hidden="true" class="w-6 h-6" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.001 9C10.3436 9 9.00098 10.3431 9.00098 12C9.00098 13.6573 10.3441 15 12.001 15C13.6583 15 15.001 13.6569 15.001 12C15.001 10.3427 13.6579 9 12.001 9ZM12.001 7C14.7614 7 17.001 9.2371 17.001 12C17.001 14.7605 14.7639 17 12.001 17C9.24051 17 7.00098 14.7629 7.00098 12C7.00098 9.23953 9.23808 7 12.001 7ZM18.501 6.74915C18.501 7.43926 17.9402 7.99917 17.251 7.99917C16.5609 7.99917 16.001 7.4384 16.001 6.74915C16.001 6.0599 16.5617 5.5 17.251 5.5C17.9393 5.49913 18.501 6.0599 18.501 6.74915ZM12.001 4C9.5265 4 9.12318 4.00655 7.97227 4.0578C7.18815 4.09461 6.66253 4.20007 6.17416 4.38967C5.74016 4.55799 5.42709 4.75898 5.09352 5.09255C4.75867 5.4274 4.55804 5.73963 4.3904 6.17383C4.20036 6.66332 4.09493 7.18811 4.05878 7.97115C4.00703 9.0752 4.00098 9.46105 4.00098 12C4.00098 14.4745 4.00753 14.8778 4.05877 16.0286C4.0956 16.8124 4.2012 17.3388 4.39034 17.826C4.5591 18.2606 4.7605 18.5744 5.09246 18.9064C5.42863 19.2421 5.74179 19.4434 6.17187 19.6094C6.66619 19.8005 7.19148 19.9061 7.97212 19.9422C9.07618 19.9939 9.46203 20 12.001 20C14.4755 20 14.8788 19.9934 16.0296 19.9422C16.8117 19.9055 17.3385 19.7996 17.827 19.6106C18.2604 19.4423 18.5752 19.2402 18.9074 18.9085C19.2436 18.5718 19.4445 18.2594 19.6107 17.8283C19.8013 17.3358 19.9071 16.8098 19.9432 16.0289C19.9949 14.9248 20.001 14.5389 20.001 12C20.001 9.52552 19.9944 9.12221 19.9432 7.97137C19.9064 7.18906 19.8005 6.66149 19.6113 6.17318C19.4434 5.74038 19.2417 5.42635 18.9084 5.09255C18.573 4.75715 18.2616 4.55693 17.8271 4.38942C17.338 4.19954 16.8124 4.09396 16.0298 4.05781C14.9258 4.00605 14.5399 4 12.001 4ZM12.001 2C14.7176 2 15.0568 2.01 16.1235 2.06C17.1876 2.10917 17.9135 2.2775 18.551 2.525C19.2101 2.77917 19.7668 3.1225 20.3226 3.67833C20.8776 4.23417 21.221 4.7925 21.476 5.45C21.7226 6.08667 21.891 6.81333 21.941 7.8775C21.9885 8.94417 22.001 9.28333 22.001 12C22.001 14.7167 21.991 15.0558 21.941 16.1225C21.8918 17.1867 21.7226 17.9125 21.476 18.55C21.2218 19.2092 20.8776 19.7658 20.3226 20.3217C19.7668 20.8767 19.2076 21.22 18.551 21.475C17.9135 21.7217 17.1876 21.89 16.1235 21.94C15.0568 21.9875 14.7176 22 12.001 22C9.28431 22 8.94514 21.99 7.87848 21.94C6.81431 21.8908 6.08931 21.7217 5.45098 21.475C4.79264 21.2208 4.23514 20.8767 3.67931 20.3217C3.12348 19.7658 2.78098 19.2067 2.52598 18.55C2.27848 17.9125 2.11098 17.1867 2.06098 16.1225C2.01348 15.0558 2.00098 14.7167 2.00098 12C2.00098 9.28333 2.01098 8.94417 2.06098 7.8775C2.11014 6.8125 2.27848 6.0875 2.52598 5.45C2.78014 4.79167 3.12348 4.23417 3.67931 3.67833C4.23514 3.1225 4.79348 2.78 5.45098 2.525C6.08848 2.2775 6.81348 2.11 7.87848 2.06C8.94514 2.0125 9.28431 2 12.001 2Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="ml-1.5 underline">Instagram</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>
