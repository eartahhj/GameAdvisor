@extends('layouts.base')

@section('title') {{ _('Homepage') }} @endsection

@section('content')
<section class="template-default template-homepage">
    <div class="container">
        <h2>Homepage</h2>

        @if (!$latestReviews->isEmpty())
        <section>
            <p class="title is-3">
                {{ _('Latest reviews') }} (<a href="{{ route('reviews.index') }}">{{ _('All reviews')}}</a>)
            </p>
            <ul class="items-list reviews-list">
                @foreach ($latestReviews as $review)
                    <x-reviews.list-item :review="$review"/>
                @endforeach
            </ul>
        </section>
        @endif

        @if (!$games->isEmpty())
        <section>
            <p class="title is-3">
                {{ _('Games') }} (<a href="{{ route('games.index') }}">{{ _('All games')}}</a>)
            </p>
            <ul class="items-list grid grid-mobile games-list">
                @foreach ($games as $game)
                    <x-games.list-item :game="$game"/>
                @endforeach
            </ul>

            @if (!empty($games->links()))
            <nav class="pager">
                {{ $games->onEachSide(3)->links() }}
            </nav>
            @endif

        </section>
        @endif
    </div>
</section>

@endsection

{{-- @guest
    <form method="POST" action="/profile">
        <input type="text" name="" value="">
        @csrf
    </form>
@endguest

@auth
    Welcome {{ $name }}
@endauth

@hasSection('navigation')
    <div class="pull-right">
        @yield('navigation')
    </div>

    <div class="clearfix"></div>
@endif --}}

{{-- @sectionMissing('navigation')
    <div class="pull-right">
        @include('default-navigation')
    </div>
@endif --}}

{{-- @foreach ($games as $game)
    <p>This is game {{ $game->id }}</p>
@endforeach --}}

{{-- {{ url("/games/{$game->id}"); }} --}}

<?php
// use Illuminate\Support\Facades\Auth;
//
// // Retrieve the currently authenticated user...
// $user = Auth::user();
//
// // Retrieve the currently authenticated user's ID...
// $id = Auth::id();
//
// if (Auth::check()) {
//     // The user is logged in...
// }
?>
