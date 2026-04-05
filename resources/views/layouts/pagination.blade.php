@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Pagination">
        <div class="pagination-info">
            Показано
            @if ($paginator->firstItem())
                <strong>{{ $paginator->firstItem() }}</strong>
                —
                <strong>{{ $paginator->lastItem() }}</strong>
            @else
                {{ $paginator->count() }}
            @endif
            из
            <strong>{{ $paginator->total() }}</strong>
        </div>

        <div class="pagination-links">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled">&lsaquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" rel="prev">&lsaquo;</a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination-btn disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" rel="next">&rsaquo;</a>
            @else
                <span class="pagination-btn disabled">&rsaquo;</span>
            @endif
        </div>
    </nav>
@endif
