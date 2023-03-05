@extends('layouts.base')

@section('content')
<section id="page-review" class="template-default template-reviews">
    <div class="container">
        <?php if (!$review->approved and $review->user_id == auth()->user()->id): ?>
        <div class="message is-warning">
            <div class="message-header"><?= _('Warning') ?></div>
            <div class="message-body"><?= _('This review has not been approved yet, and is visible only to you.') ?></div>
        </div>
        <?php endif?>
        <div class="grid grid-7-3">
            <article>
                <h1 class="title is-2">{{ $pageTitle }}</h1>
                <p class="mb-4">
                    <a href="{{ route('games.show', $game->id) }}">{{ $game->title }}</a>
                </p>
                <p>{{ $review->text }}</p>
            </article>
            <aside>
                <figure class="image">
                    @if ($review->image)
                    <img src="/storage/{{ $review->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}">
                    @else
                    <img src="/storage/images/placeholders/review{{ rand(1, 3) }}.png" alt="" width="800" height="600">
                    @endif
                </figure>
                <dl>
                    <dt>{{ _('Posted at') }}</dt>
                    <dd><time class="date" datetime="{{ $review->updated_at }}"> {{ formatDate($review->updated_at) }}</time></dd>
                    <dt>{{ _('Author') }}</dt>
                    <dd>
                        @if ($user)
                        <a href="{{ route('users.show', $user) }}">{{ $review->author_name }}</a>
                        @else
                        {{ $review->author_name }}
                        @endif
                    </dd>
                    @if ($review->author_email)
                    <dt>{{ _('Email') }}</dt>
                    <dd>
                        @if (auth()->user() and auth()->user()->email_verified_at)
                            {{ $review->author_email }}
                        @else
                            {{ substr($review->author_email, 0, 1) }}*******
                        @endif
                    </dd>
                    @endif
                </dl>
            </aside>
        </div>
    </div>
</section>
@endsection
