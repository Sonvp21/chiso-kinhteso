@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2']) }}>
        <i class="fa-solid fa-circle-check"></i> {{ $status }}
    </div>
@endif
