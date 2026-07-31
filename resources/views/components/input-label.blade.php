@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-medium text-gray-500 mb-1']) }}>
    {{ $value ?? $slot }}
</label>
