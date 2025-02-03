@if ($contained)
<div class="max-w-7xl mx-auto w-full">
@endif
<nav class="flex items-center justify-between border-b w-full p-4 lg:px-8 xl:px-0 text-lg mt-0.5">
            <a href="{{ route('welcome') }}" class="flex items-center lg:w-0 lg:flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 mt-px">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                        clip-rule="evenodd" />
                    <span class="ml-1.5 underline leading-none">Retour au site</span>
                </svg>
            </a>


            <a class="flex whitespace-nowrap">
                <span>Backoffice</span>
            </a>
            <ul class="flex space-x-6 items-center md:justify-end lg:w-0 lg:flex-1">
                @foreach ($navigation as $item)
                    <li>
                        <a href="{{ $item['href'] }}" class="whitespace-nowrap">
                            <span
                                class="underline @if ($item['active']) text-brand-600 font-semibold @endif">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
</nav>
@if ($contained)
</div>
@endif
