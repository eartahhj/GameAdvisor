<li class="review-single">
    <article class="box p-0">
        <header>
            <div class="grid grid-align-center">
                <div class="grid-col">
                    <p class="author-name">{{ _('Author') }}: {{ $review->author_name }}</p>
                </div>
                @if (!empty($game) and !$game->isEmpty())
                    <div class="grid-col">
                        <p class="review-game">
                            {{ _('Game') }}: <a href="{{ route('games.show', $review->game_id) }}">{{ $game->title }}</a>
                        </p>
                    </div>
                @endif
                <div class="grid-col">
                    <p class="review-rating">
                        {{ _('Rating') }}:
                        <span class="sr-only">{{ sprintf(_('%d out of %d'), intval($review->rating), 5) }}</span>
                        @for ($stars = 1; $stars <= 5; $stars++)
                            <span class="star star-<?=($stars <= $review->rating ? 'on' : 'off')?>" aria-hidden="true"></span>
                        @endfor
                    </p>
                </div>
                <div class="grid-col">
                    <p class="review-date">
                        {{ $review->updated_at }}
                    </p>
                </div>
            </div>
        </header>
        <div class="review-text">
            <p class="subtitle is-4"><strong>{{ $review->title }}</strong></p>
            <p class="text">{{ $review->text }}</p>
        </div>
    </article>
</li>
