@props(['recipe', 'excerptOnly', 'href'])
<a href="{{ $href }}" {{ $attributes->class('flex flex-col max-w-lg w-full') }}>
    {{ $recipe->getFirstMedia('banner')
        ?->img('thumb')->attributes([
            'loading' => 'lazy',
        ]) }}

    <div class="flex flex-col flex-1">
        <div class=" border-l border-gray-300 pt-2 pl-4">
            <h2 class="text-xl font-semibold underline">{{ $recipe->title }}</h2>
            <p class="text-lg mt-1 @if ($excerptOnly) truncate @endif">
                {{ $recipe->description }}
            </p>
        </div>
    </div>
</a>
