@if ( $paginator->lastPage() > 1)
<nav aria-label="Page navigation" class="d-flex justify-content-center mt-3">
    <ul class="pagination">
        <li class="page-item {{ $paginator->currentPage() == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">
                    {{ $i }}
                </a>
            </li>
            @endfor
            <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            </li>
    </ul>
</nav>
@endif