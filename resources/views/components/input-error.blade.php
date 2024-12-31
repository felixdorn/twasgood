@props(['name'])
@error($name)
    <p {{ $attributes->class('text-sm text-red-600 mt-1') }}>
    </p>
@enderror
