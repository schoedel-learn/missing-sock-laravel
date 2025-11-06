@props([
    'paginator' => null,
    'onEachSide' => 2,
])

@if($paginator && $paginator->hasPages())
    <nav aria-label="Pagination" {{ $attributes->merge(['class' => 'pagination']) }}>
        {{-- Previous Page Link --}}
        @if($paginator->onFirstPage())
            <span class="pagination-item disabled" aria-disabled="true">
                <span aria-hidden="true">&laquo;</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item" rel="prev" aria-label="Previous page">
                &laquo;
            </a>
        @endif
        
        {{-- Pagination Elements --}}
        @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if($page == $paginator->currentPage())
                <span class="pagination-item active" aria-current="page">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" class="pagination-item">
                    {{ $page }}
                </a>
            @endif
        @endforeach
        
        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item" rel="next" aria-label="Next page">
                &raquo;
            </a>
        @else
            <span class="pagination-item disabled" aria-disabled="true">
                <span aria-hidden="true">&raquo;</span>
            </span>
        @endif
    </nav>
@endif

