@props([
    'label' => '',
    'value' => 0,
    'icon'  => null,
    'color' => 'indigo',
])

@php
    $colorClasses = match ($color) {
        'green'  => 'bg-green-100 text-green-700',
        'yellow' => 'bg-yellow-100 text-yellow-700',
        'red'    => 'bg-red-100 text-red-700',
        default  => 'bg-indigo-100 text-indigo-700',
    };
@endphp

<div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-center justify-between">
        <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
        @if ($icon)
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg {{ $colorClasses }}">
                {!! $icon !!}
            </span>
        @endif
    </div>
    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $value }}</p>
</div>
