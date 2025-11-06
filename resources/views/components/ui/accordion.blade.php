@props([
    'id' => 'accordion-' . uniqid(),
    'items' => [],
    'allowMultiple' => false,
])

@php
    $accordionId = $id;
@endphp

<div class="accordion" id="{{ $accordionId }}">
    @foreach($items as $index => $item)
        @php
            $itemId = $accordionId . '-item-' . $index;
            $headerId = $itemId . '-header';
            $contentId = $itemId . '-content';
            $title = is_array($item) ? ($item['title'] ?? 'Item ' . ($index + 1)) : $item;
            $content = is_array($item) ? ($item['content'] ?? '') : '';
            $isOpen = is_array($item) && ($item['open'] ?? false);
        @endphp
        
        <div class="accordion-item {{ $isOpen ? 'active' : '' }}">
            <button
                type="button"
                class="accordion-header"
                id="{{ $headerId }}"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                aria-controls="{{ $contentId }}"
                onclick="toggleAccordion('{{ $itemId }}', {{ $allowMultiple ? 'true' : 'false' }})"
            >
                <span>{{ $title }}</span>
                <svg class="accordion-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <div
                class="accordion-content {{ $isOpen ? 'show' : '' }}"
                id="{{ $contentId }}"
                aria-labelledby="{{ $headerId }}"
            >
                {!! $content !!}
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
    function toggleAccordion(itemId, allowMultiple) {
        const item = document.getElementById(itemId);
        if (!item) return;
        
        const header = item.querySelector('.accordion-header');
        const content = item.querySelector('.accordion-content');
        const isActive = item.classList.contains('active');
        
        if (!allowMultiple) {
            // Close all other items in the same accordion
            const accordion = item.closest('.accordion');
            accordion.querySelectorAll('.accordion-item').forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                    const otherHeader = otherItem.querySelector('.accordion-header');
                    const otherContent = otherItem.querySelector('.accordion-content');
                    otherHeader.setAttribute('aria-expanded', 'false');
                    otherContent.classList.remove('show');
                }
            });
        }
        
        // Toggle current item
        if (isActive) {
            item.classList.remove('active');
            header.setAttribute('aria-expanded', 'false');
            content.classList.remove('show');
        } else {
            item.classList.add('active');
            header.setAttribute('aria-expanded', 'true');
            content.classList.add('show');
        }
    }
</script>
@endpush

