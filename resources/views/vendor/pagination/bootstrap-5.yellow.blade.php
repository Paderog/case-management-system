@if($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">

        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link bg-dark text-white border-secondary"><<</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link bg-dark text-white border-secondary" href="{{ $paginator->previousPageUrl() }}" rel="prev"><<</a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link bg-dark text-white border-secondary">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link bg-primary border-primary">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link bg-dark text-white border-secondary" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link bg-dark text-white border-secondary" href="{{ $paginator->nextPageUrl() }}" rel="next">>></a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link bg-dark text-white border-secondary">>></span>
            </li>
        @endif

    </ul>
</nav>
@endif