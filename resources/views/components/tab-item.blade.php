@props(['active', 'value', 'key'])
<form>
    <input name="{{ $key ?? 'state' }}" type="hidden" value="{{ $value }}" />
    <button type="submit" @if ($active) aria-current="page" @endif
        {{ $attributes->class([
            'whitespace-nowrap border-b-2 py-1 font-medium' => true,
            'border-brand-500 text-brand-600' => $active,
            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !$active,
        ]) }}>
        {{ $slot }}
    </button>
</form>
