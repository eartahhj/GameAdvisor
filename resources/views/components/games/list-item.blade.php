<li class="game-single">
    <article class="box p-0">
        <header>
            <div class="grid grid-align-center">
                <div class="grid-col">
                    @if ($game->image and $image)
                        <figure>
                            <img src="/storage/{{ $game->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}" loading="lazy">
                        </figure>
                    @endif
                    <p class="game-title">
                        <a href="{{ route('games.show', $game->id) }}">{{ $game->title }}</a>
                    </p>
                </div>
                <div class="grid-col">
                    <p class="game-platform">
                        {{ $game->platform_name }}
                    </p>
                </div>
                <div class="grid-col">
                    <a href="{{ route('reviews.create', $game->id) }}" rel="nofollow">{{ _('Review this game') }}</a>
                </div>
            </div>
        </header>
        <div class="game-text">
            <p class="text">{{ $game->description }}</p>
            @if (!empty($href) and !empty($rel) and !empty($text))
                <a href="{{ $href }}" rel="{{ $rel }}">{{ $text }}</a>
            @endif
        </div>
    </article>
</li>
