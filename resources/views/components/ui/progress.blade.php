@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'default', // default, success, warning, error
    'showLabel' => false,
    'label' => null,
])

@php
    $percentage = min(100, max(0, ($value / $max) * 100));
    $barClasses = 'progress-bar';
    if ($variant !== 'default') {
        $barClasses .= ' progress-bar-' . $variant;
    }
    $displayLabel = $label ?? ($showLabel ? round($percentage) . '%' : '');
@endphp

<div {{ $attributes->merge(['class' => 'progress']) }}>
    <div 
        class="{{ $barClasses }}" 
        role="progressbar" 
        aria-valuenow="{{ $value }}" 
        aria-valuemin="0" 
        aria-valuemax="{{ $max }}"
        style="width: {{ $percentage }}%"
    >
        @if($displayLabel)
            <span class="sr-only">{{ $displayLabel }}</span>
        @endif
    </div>
</div>

@if($displayLabel && !$label)
    <p class="text-sm text-gray-600 mt-1 text-center">{{ $displayLabel }}</p>
@endif

