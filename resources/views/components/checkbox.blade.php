@props(['name', 'checked'])
<input id="{{ $name }}" name="{{ $name }}" type="checkbox"
    @if ($checked) checked="checked" @endif
    class="checked:bg-brand-600 hover:checked:bg-brand-700 border border-gray-300 checked:border-brand-600 focus:checked:bg-brand-600 focus:ring-brand-600 rounded-[4px]"
/>
