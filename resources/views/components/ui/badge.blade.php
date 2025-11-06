@props([
    'variant' => 'primary', // primary, accent, success, warning, error, info, gray
])

@php
    $classes = 'badge badge-' . $variant;
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

