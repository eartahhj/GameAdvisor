@if ($paginator->hasPages())
    <nav class="pagination">
        @if ($paginator->onFirstPage())
            <a class="pagination-previous is-disabled" aria-disabled="disabled" tabindex="-1">
                {{ _('Previous page') }}
            </a>
        @else
            <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}">
                {{ _('Previous page') }}
            </a>
        @endif

        <ul class="pagination-list">
            @if ($paginator->onFirstPage())
                <li>
                    <span aria-hidden="true" class="pagination-link is-disabled">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-link">&lsaquo;</a>
                </li>
            @endif

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="pagination-ellipsis">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                                <a aria-current="page" class="pagination-link is-current">{{ $page }}</a>
                            </li>
                        @else
                            <li><a href="{{ $url }}" class="pagination-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-link">&rsaquo;</a>
                </li>
            @else
                <li>
                    <span aria-hidden="true" class="pagination-link is-disabled">&rsaquo;</span>
                </li>
            @endif
        </ul>

        @if ($paginator->hasMorePages())
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}">
                {{ _('Next page') }}
            </a>
        @else
            <a class="pagination-next is-disabled" aria-disabled="disabled" tabindex="-1">
                {{ _('Next page') }}
            </a>
        @endif
    </nav>
@endif
