@props(['name'])
@error($name)
    <p {{ $attributes->class('text-red-600 mt-1') }}>
    </p>
@enderror
