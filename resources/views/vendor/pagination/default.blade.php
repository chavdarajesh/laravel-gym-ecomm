@if ($paginator->hasPages())
<nav class="blog-pagination justify-content-center d-flex">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link disabled" aria-label="Previous">
                <i class="ti-angle-left"></i>
            </span>
        </li>
        @else
        <li class="page-item">
            <span data-url="{{ $paginator->previousPageUrl() }}" class="page-link active-page" aria-label="Previous">
                <i class="ti-angle-left"></i>
            </span>
        </li>
        @endif

        {{-- Pagination Links --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item active">
                <span class="page-link">{{ $page }}</span>
            </li>
            @else
            <li class="page-item">
                <span data-url="{{ $url }}" class="page-link active-page">{{ $page }}</span>
            </li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <span data-url="{{ $paginator->nextPageUrl() }}" class="page-link active-page" aria-label="Next">
                <i class="ti-angle-right"></i>
            </span>
        </li>
        @else
        <li class="page-item disabled">
            <span class="page-link disabled" aria-label="Next">
                <i class="ti-angle-right"></i>
            </span>
        </li>
        @endif
    </ul>
</nav>
@endif
