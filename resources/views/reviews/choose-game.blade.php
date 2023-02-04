@extends('layouts.base')

@section('title') {{ _('Choose a game to review') }} @endsection

@section('content')
<section class="template-default template-reviews">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">
            {{ _('Choose a game to review') }}
            @if (!empty($platform))
                ({{ $platform->name }})
            @endif
        </p>
        <ul class="items-list grid grid-mobile games-list">
            @foreach ($games as $game)
                @php
                    $href = route('reviews.create', $game);
                    $rel = 'nofollow';
                    $text = _('Leave a review');
                @endphp
                <x-games-list-item :game="$game" :href="$href" :rel="$rel" :text="$text" />
            @endforeach
            {{-- @each('games.list-item', $games, 'game') --}}
        </ul>

        @if (!empty($games->links()))
            <nav class="pager">
                {{ $games->links() }}
            </nav>
        @endif
    </div>
</section>

@endsection
