@if ($paginator->hasPages())
    <nav class="pagination">
        @if ($paginator->onFirstPage())
            <a class="pagination-previous is-disabled">
                {{ _('Previous page') }}
            </a>
        @else
            <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}">
                {{ _('Previous page') }}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}">
                {{ _('Next page') }}
            </a>
        @else
            <a class="pagination-next is-disabled">
                {{ _('Next page') }}
            </a>
        @endif
    </nav>
@endif
