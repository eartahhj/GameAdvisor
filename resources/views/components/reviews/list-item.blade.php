<li class="card review-single">
    <article>
        <div class="card-image">
            <figure class="image">
                @if ($review->image)
                <img src="/storage/{{ $review->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}" loading="lazy">
                @else
                <img src="/storage/images/placeholders/review{{ rand(1, 3) }}.png" alt="" width="800" height="600" loading="lazy">
                @endif
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-48x48">
                        @if ($review->author_email)
                        <img src="{{ getLibravatar($review->author_email) }}" alt="" width="48" height="48">
                        @else
                        <img src="/img/default-avatar.png" alt="" width="48" height="48">
                        @endif
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-5">{{ $review->author_name }}</p>
                </div>
            </div>

            <div class="content">
                @if (!empty($review->game_title))
                <p class="title is-5">
                    {{ _('Game') }}: <a href="{{ route('games.show', $review->game_id) }}">{{ $review->game_title }}</a>
                </p>
                @endif
                <p class="review-rating">
                    {{ _('Rating') }}:
                    <span class="sr-only">{{ sprintf(_('%d out of %d'), intval($review->rating), 5) }}</span>
                    @for ($stars = 1; $stars <= 5; $stars++)
                        <span class="star star-<?=($stars <= $review->rating ? 'on' : 'off')?>" aria-hidden="true"></span>
                    @endfor
                </p>
                <p>
                    <strong>{{ $review->title }}</strong>
                </p>
                <p>
                    {{ $review->getPreviewText() }}
                </p>
                <time datetime="{{ $review->updated_at }}">{{ formatDate($review->updated_at) }}</time>
                <p class="buttons">
                    <a href="{{ route('reviews.show', $review->id) }}" rel="nofollow" class="button is-primary">{{ _('Read the full review') }}</a>
                    @if (auth()->user() and (auth()->user()->id == $review->user_id))
                    <a href="{{ route('user.review.edit', $review) }}" class="button is-warning">{{ _('Edit your review') }}</a>
                    @endif
                    @if (auth()->user() and auth()->user()->is_superadmin)
                    <a href="{{ route('reviews.edit', $review) }}" class="button is-dark">{{ _('Edit') }}</a>
                    <x-reviews.form-approve :review="$review"></x-reviews>
                    @endif
                </p>
            </div>
        </div>
        
    </article>
</li>
