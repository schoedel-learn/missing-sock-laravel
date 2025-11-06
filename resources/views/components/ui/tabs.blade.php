@props([
    'id' => 'tabs-' . uniqid(),
    'tabs' => [],
    'activeTab' => 0,
])

@php
    $tabId = $id;
@endphp

<div class="tabs" id="{{ $tabId }}">
    <div class="tabs-list" role="tablist">
        @foreach($tabs as $index => $tab)
            @php
                $tabName = is_array($tab) ? ($tab['name'] ?? $tab['label'] ?? 'Tab ' . ($index + 1)) : $tab;
                $tabIdAttr = $tabId . '-tab-' . $index;
                $contentIdAttr = $tabId . '-content-' . $index;
                $isActive = $index === $activeTab;
            @endphp
            <button
                type="button"
                class="tab {{ $isActive ? 'active' : '' }}"
                role="tab"
                id="{{ $tabIdAttr }}"
                aria-controls="{{ $contentIdAttr }}"
                aria-selected="{{ $isActive ? 'true' : 'false' }}"
                onclick="switchTab('{{ $tabId }}', {{ $index }})"
            >
                {{ $tabName }}
            </button>
        @endforeach
    </div>
    
    <div class="mt-4">
        @foreach($tabs as $index => $tab)
            @php
                $contentIdAttr = $tabId . '-content-' . $index;
                $isActive = $index === $activeTab;
            @endphp
            <div
                class="tab-content {{ $isActive ? 'active' : '' }}"
                role="tabpanel"
                id="{{ $contentIdAttr }}"
                aria-labelledby="{{ $tabId }}-tab-{{ $index }}"
            >
                @if(is_array($tab) && isset($tab['content']))
                    {!! $tab['content'] !!}
                @else
                    {{ $slot }}
                @endif
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tabContainerId, tabIndex) {
        const container = document.getElementById(tabContainerId);
        if (!container) return;
        
        // Hide all tab contents
        container.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // Remove active class from all tabs
        container.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
            tab.setAttribute('aria-selected', 'false');
        });
        
        // Show selected tab content
        const selectedContent = container.querySelector(`#${tabContainerId}-content-${tabIndex}`);
        const selectedTab = container.querySelector(`#${tabContainerId}-tab-${tabIndex}`);
        
        if (selectedContent) {
            selectedContent.classList.add('active');
        }
        if (selectedTab) {
            selectedTab.classList.add('active');
            selectedTab.setAttribute('aria-selected', 'true');
        }
    }
</script>
@endpush

