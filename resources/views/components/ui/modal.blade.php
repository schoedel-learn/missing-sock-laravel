@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
    'size' => 'default', // sm, default, lg, xl
    'show' => false,
])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'default' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];
@endphp

<!-- Modal Backdrop -->
<div class="modal-backdrop {{ $show ? 'show' : '' }}" id="{{ $id }}-backdrop"></div>

<!-- Modal -->
<div 
    class="modal {{ $show ? 'show' : '' }}" 
    id="{{ $id }}"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
>
    <div class="modal-dialog">
        <div class="modal-content {{ $sizeClasses[$size] }}">
            @if($title)
                <div class="modal-header">
                    <h3 class="modal-title" id="{{ $id }}-title">{{ $title }}</h3>
                    <button 
                        type="button" 
                        class="modal-close" 
                        aria-label="Close modal"
                        onclick="document.getElementById('{{ $id }}').classList.remove('show'); document.getElementById('{{ $id }}-backdrop').classList.remove('show');"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
            
            <div class="modal-body">
                {{ $slot }}
            </div>
            
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Close modal on backdrop click
    document.getElementById('{{ $id }}-backdrop')?.addEventListener('click', function() {
        document.getElementById('{{ $id }}').classList.remove('show');
        this.classList.remove('show');
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('{{ $id }}');
            if (modal?.classList.contains('show')) {
                modal.classList.remove('show');
                document.getElementById('{{ $id }}-backdrop').classList.remove('show');
            }
        }
    });
</script>
@endpush

