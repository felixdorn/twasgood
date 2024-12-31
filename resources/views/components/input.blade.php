@props(['name'])
<input
    {{ $attributes->merge([
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' =>
            'block w-full border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600',
    ]) }} />
