@if ($paginator->hasPages())
    <nav aria-label="Page Pagination">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')" tabindex="-1" aria-disabled="false">Previous</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-disabled="true">{{ $element }}</a>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')" tabindex="-1" aria-disabled="false">Previous</a>
                </li>
            @else
                <li class="page-item disabled" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">Next</span>
                </li>
            @endif
        </ul>
    </nav>
    <p>
        Menampikan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }}
        dari total {{ $paginator->total() }} data
    </p>
@endif
