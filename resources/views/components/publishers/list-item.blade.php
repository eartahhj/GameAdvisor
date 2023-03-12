<li class="tile is-parent notification item-single publisher-single background-1">
    <article class="tile is-child">
        <figure class="image">
            @if ($publisher->logo and $logo)
            <img src="/storage/{{ $publisher->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $image->height() }}" loading="lazy">
            @else
            <img src="/storage/images/placeholders/publisher1.png" alt="" width="800" height="600" loading="lazy">
            @endif
        </figure>
        <div class="tile-content">
            <h2 class="title is-4 publisher-title">
                <a href="{{ route('publishers.show', $publisher->id) }}">{{ $publisher->name }}</a>
            </h2>
            <p class="text publisher-text">{{ $publisher->description }}</p>
            <p class="buttons">
                @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}" class="button is-secondary">{{ $text }}</a>
                @endif
                @if (!empty(auth()->user()) and auth()->user()->is_superadmin)
                <a href="{{ route('publishers.edit', $publisher->id) }}" class="button is-dark">{{ _('Edit') }}</a>
                @endif
            </p>
        </div>
    </article>
</li>
