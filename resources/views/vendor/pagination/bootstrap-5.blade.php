@if ($paginator->hasPages())
<nav aria-label="Pagination" class="resto-pagination-wrapper">
    <ul class="resto-pagination">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="resto-page-item disabled">
                <span class="resto-page-link">‹ Prev</span>
            </li>
        @else
            <li class="resto-page-item">
                <a class="resto-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Prev</a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="resto-page-item disabled">
                    <span class="resto-page-link">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="resto-page-item active">
                            <span class="resto-page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="resto-page-item">
                            <a class="resto-page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="resto-page-item">
                <a class="resto-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next ›</a>
            </li>
        @else
            <li class="resto-page-item disabled">
                <span class="resto-page-link">Next ›</span>
            </li>
        @endif

    </ul>
    <div class="resto-pagination-info">
        Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} menu
    </div>
</nav>
@endif
