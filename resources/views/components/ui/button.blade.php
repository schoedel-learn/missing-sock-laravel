@props([
    'variant' => 'primary', // primary, secondary, accent, outline, ghost, danger, success
    'size' => 'default', // sm, default, lg, xl
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'href' => null,
    'target' => null,
])

@php
    $baseClasses = 'btn';
    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
        'danger' => 'btn-danger',
        'success' => 'btn-success',
    ];
    $sizeClasses = [
        'sm' => 'btn-sm',
        'default' => '',
        'lg' => 'btn-lg',
        'xl' => 'btn-xl',
    ];
    
    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
    if ($loading) {
        $classes .= ' btn-loading';
    }
@endphp

@if($href)
    <a 
        href="{{ $href }}" 
        {{ $target ? 'target="' . $target . '"' : '' }}
        @if($disabled || $loading) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </a>
@else
    <button 
        type="{{ $type }}"
        @if($disabled || $loading) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@endif

