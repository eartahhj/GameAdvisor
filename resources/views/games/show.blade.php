@extends('layouts.base')

@section('content')
<section class="template-default template-games">
    <div class="container">
        
        <div class="grid grid-7-3">
            <article>
                <h1 class="title is-2">{{ $pageTitle }}</h1>
                @if ($game->description)
                <p>{{ $game->description }}</p>
                @endif
            </article>

            <aside>
                @if ($game->image and $image)
                <figure class="image">
                    <img src="/storage/{{ $game->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}">
                </figure>
                @endif

                <dl>
                    <dt>{{ _('Rating') }}:</dt>
                    <dd class="game-rating">
                        <span class="sr-only">{{ sprintf(_('%d out of %d'), intval($rating), 5) }}</span>
                        @for ($stars = 1; $stars <= 5; $stars++)
                        <span class="star star-<?=($stars <= $rating ? 'on' : 'off')?>" aria-hidden="true"></span>
                        @endfor
                        @if ($numberOfVotes)
                        <span class="votes-number">({{ sprintf(ngettext('%d vote', '%d votes', $numberOfVotes), $numberOfVotes) }})</span>
                        @endif
                    </dd>
                    @if ($developer)
                    <dt>{{ _('Developer') }}</dt>
                    <dd>
                        <a href="{{ route('developers.show', $developer->id) }}">{{ $developer->name }}</a>
                    </dd>
                    @endif
                    @if ($publisher)
                    <dt>{{ _('Publisher') }}</dt>
                    <dd>
                        <a href="{{ route('publishers.show', $publisher->id) }}">{{ $publisher->name }}</a>
                    </dd>
                    @endif
                </dl>
            </aside>
        </div>

        @if (auth()->user() and auth()->user()->is_superadmin)
            <p class="mt-6 mb-6">
                <x-button-bulma link="{{ route('games.edit', $game) }}" text="{{ _('Edit') }}" class="is-warning"></x-button-bulma>
                <x-button-bulma link="{{ route('games.create') }}" text="{{ _('Create new') }}" class="is-info"></x-button-bulma>
            </p>
        @endif
    
        @if (!$reviews->isEmpty())
        <p class="title is-3">{{ sprintf(_('Reviews for %s'), $game->title) }}</p>
            @if ($reviews->count() > 12)
            <x-form-order-by>
                <x-slot:action>{{ route('games.show', $game->id) }}</x-slot>
            </x-form-order-by>
            @endif
    
            <ul class="grid reviews-list">
                @foreach ($reviews as $review)
                    <x-reviews.list-item :review="$review" />
                @endforeach
            </ul>
        @else
            <p>{{ _('No one has reviewed this game yet.') }} <a href="{{ route('reviews.create', $game->id) }}" rel="nofollow">{{ _('Write a review') }}</a> </p>
        @endif
    </div>
</section>

@endsection
