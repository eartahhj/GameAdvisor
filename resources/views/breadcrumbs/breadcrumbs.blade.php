@unless ($breadcrumbs->isEmpty())
<nav class="breadcrumb" aria-label="{{ _('Breadcrumbs') }}">
    <h2 class="sr-only">{{ _('You are here:') }}</h2>
    <ol>
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->last)
                @if ($breadcrumb->url)
                    <li class="is-active"><a>{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="is-active"><a>{{ $breadcrumb->title }}</a></li>
                @endif
            @else
                @if ($breadcrumb->url)
                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="is-active"><a>{{ $breadcrumb->title }}</a></li>
                @endif
            @endif

        @endforeach
    </ol>
</nav>
@endunless