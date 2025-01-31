@props(['author'])
<div class="lg:flex clear-both">
    @if ($author->getFirstMedia('portrait'))
        {{ $author->getFirstMedia('portrait')->img()->attributes([
                'loading' => 'lazy',
                'class' => 'w-36 h-auto object-cover object-left float-left lg:float-none mr-4 lg:mr-0',
            ]) }}
    @endif

    <div class="@if ($author->portrait !== null) lg:px-4 @endif">
        <h3 class="font-semibold text-xl">
            {{ $author->name }}
        </h3>
        <p class="max-w-lg text-base mt-1 text-lg">
            {{ $author->bio }}
        </p>
    </div>
</div>
