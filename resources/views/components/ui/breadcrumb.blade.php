@props([
    'items' => [],
])

<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'breadcrumb']) }}>
    @foreach($items as $index => $item)
        @php
            $isLast = $index === count($items) - 1;
            $url = is_array($item) ? ($item['url'] ?? '#') : '#';
            $label = is_array($item) ? ($item['label'] ?? $item['title'] ?? '') : $item;
        @endphp
        
        <span class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
            @if(!$isLast && $url !== '#')
                <a href="{{ $url }}">{{ $label }}</a>
            @else
                {{ $label }}
            @endif
        </span>
        
        @if(!$isLast)
            <span class="breadcrumb-separator" aria-hidden="true">/</span>
        @endif
    @endforeach
</nav>

