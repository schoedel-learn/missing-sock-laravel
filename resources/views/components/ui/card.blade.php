@props([
    'variant' => 'default', // default, primary, accent, success, warning, error
    'hover' => false,
    'bordered' => false,
    'flat' => false,
])

@php
    $classes = 'card';
    if ($hover) {
        $classes .= ' card-hover';
    }
    if ($bordered) {
        $classes .= ' card-bordered';
    }
    if ($flat) {
        $classes .= ' card-flat';
    }
    if ($variant !== 'default') {
        $classes .= ' card-' . $variant;
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

