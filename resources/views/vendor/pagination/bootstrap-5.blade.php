@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between align-items-center mt-5">
        <div class="small fw-bold text-muted">
            Menampilkan <span class="text-dark">{{ $paginator->firstItem() }}</span> – <span class="text-dark">{{ $paginator->lastItem() }}</span> dari <span class="text-primary">{{ $paginator->total() }}</span> Menu
        </div>

        <ul class="pagination pagination-rounded mb-0 gap-1 d-flex list-unstyled">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 shadow-sm rounded-3 px-3"><i class="fas fa-chevron-left me-1"></i> Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 shadow-sm rounded-3 px-3 text-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left me-1"></i> Prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link border-0">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link border-0 shadow rounded-3 px-3 bg-primary text-white">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link border-0 shadow-sm rounded-3 px-3 text-dark" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-0 shadow-sm rounded-3 px-3 text-dark" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="fas fa-chevron-right ms-1"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 shadow-sm rounded-3 px-3 text-muted">Next <i class="fas fa-chevron-right ms-1"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
