@props(['href'])

<a {{ $attributes->merge(['href' => $href, 'class' => 'flex items-center px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition']) }}>
    {{ $slot }}
</a>
