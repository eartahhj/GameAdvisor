<li class="tile is-parent notification item-single game-single background-4">
    <article class="tile is-child">
        <figure class="image">
            @if ($game->image and $image)
            <img src="/storage/{{ $game->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}" loading="lazy">
            @else
            <img src="/storage/images/placeholders/game{{ rand(1, 5) }}.png" alt="" width="800" height="600" loading="lazy">
            @endif
        </figure>
        <div class="tile-content">
            <h2 class="title is-4 game-title">
                <a href="{{ route('games.show', $game->id) }}">{{ $game->title }}</a>
            </h2>
            <p class="subtitle game-platform">
                {{ $game->platform_name }}
            </p>
            <p class="text game-text">{{ strip_tags($game->description) }}</p>
            <p class="buttons">
                <a href="{{ route('reviews.create', $game->id) }}" rel="nofollow" class="button is-primary">{{ _('Review this game') }}</a>
                @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}" class="button is-secondary">{{ $text }}</a>
                @endif
                @if (!empty(auth()->user()) and auth()->user()->is_superadmin)
                <a href="{{ route('games.edit', $game->id) }}" class="button is-dark">{{ _('Edit') }}</a>
                @endif
            </p>
        </div>
    </article>
</li>
