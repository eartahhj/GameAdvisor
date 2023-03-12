<li class="tile is-parent notification item-single developer-single background-3">
    <article class="tile is-child">
        <figure class="image">
            @if ($developer->logo and $logo)
            <img src="/storage/{{ $developer->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $image->height() }}" loading="lazy">
            @else
            <img src="/storage/images/placeholders/developer1.png" alt="" width="800" height="600" loading="lazy">
            @endif
        </figure>
        <div class="tile-content">
            <h2 class="title is-4 developer-title">
                <a href="{{ route('developers.show', $developer->id) }}">{{ $developer->name }}</a>
            </h2>
            <p class="text developer-text">{{ $developer->description }}</p>
            <p class="buttons">
                @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}" class="button is-secondary">{{ $text }}</a>
                @endif
                @if (!empty(auth()->user()) and auth()->user()->is_superadmin)
                <a href="{{ route('developers.edit', $developer->id) }}" class="button is-dark">{{ _('Edit') }}</a>
                @endif
            </p>
        </div>
    </article>
</li>
