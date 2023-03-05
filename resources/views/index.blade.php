@extends('layouts.base')

@section('content')
<section class="template-default template-homepage">
    <section id="home-intro">
        <div class="container has-text-centered">
            <h1 class="title is-2">{{ $pageTitle }}</h1>
            <h2 class="title is-4">{{ _('Review your favorite games. Free and simple!') }}</h2>
            <p class="mt-4">
                <a href="{{ route('games.index') }}" class="button is-medium is-link" rel="nofollow">
                    <span class="icon is-medium">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span>{{ _('Start reviewing games') }}</span>
                </a>
                <a href="{{ route('users.register.form') }}" class="button is-medium is-link" rel="nofollow">
                    <span class="icon is-medium">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    <span>{{ _('Create an account now') }}</span>
                </a>
            </p>
        </div>
    </section>

    <section id="home-section-1" class="home-section">
        <div class="grid">
            <div class="grid-col">
                <h2 class="title is-4">👍 {{ _('Reviewing games, made easy') }}</h2>
                <p class="mb-3">{{ _("Here's how:") }}</p>
                <ol>
                    <li>{!! _('Create a <strong>free account</strong>') !!}</li>
                    <li>{!! _('Search for a game by browsing the <strong>list of games</strong>, or by searching by <strong>developer</strong>, <strong>publisher</strong> or <strong>platform</strong>') !!}</li>
                    <li>{!! _('<strong>Choose your game</strong> and start reviewing, you can even send <strong>anonymous reviews</strong>') !!}</li>
                    <li>{!! _('Wait for your review to be <strong>approved</strong>') !!}</li>
                </ol>

                <p class="mt-3">{!! _('Could not find the game you were looking for? <strong>Request a game</strong> by compiling our form or by sending us an email!') !!}</p>
                <p class="buttons mt-6 is-centered">
                    <a href="{{ route('datarequests.create') }}" class="button is-medium is-warning">
                        <span class="icon is-medium">
                            <i class="fas fa-scroll"></i>
                        </span>
                        <span>{{ _('Request a game') }}</span>
                    </a>
                    <a href="mailto:{{ env('APP_EMAIL_PUBLIC') }}" class="button is-medium is-warning" rel="nofollow">
                        <span class="icon is-medium">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <span>{{ _('Send an email') }}</span>
                    </a>
                </p>
            </div>
            <div class="grid-col">
                <figure>
                    <img src="/storage/images/homepage/image1.png" alt="" width="1000" height="1000" loading="lazy" decoding="async">
                </figure>
            </div>
        </div>
    </section>

    <section id="home-section-2" class="home-section">
        <div class="grid">
            <div class="grid-col">
                <h2 class="title is-4">🎲 {{ _('Share your thoughts with others!') }}</h2>
                <p class="mb-3">{!! _('<strong>Before buying a game</strong>, we all take a look at reviews, right?') !!}</p>
                <p class="mb-3">{!! _('This is the main goal of this portal: to allow everyone to <strong>write reviews</strong> for free, even <strong>anonymously</strong>.') !!}</p>
                <p>{!! _('So, what are you waiting for? Take a look around and then leave some reviews!') !!}</p>
                <p class="buttons mt-6 is-centered">
                    <a href="{{ route('games.index') }}" class="button is-medium is-warning">
                        <span class="icon is-small">
                            <i class="fas fa-gamepad"></i>
                        </span>
                        <span>{{ _('Browse games') }}</span>
                    </a>
                    <a href="{{ route('reviews.index') }}" class="button is-medium is-warning" rel="nofollow">
                        <span class="icon is-small">
                            <i class="fas fa-eye"></i>
                        </span>
                        <span>{{ _('See all reviews') }}</span>
                    </a>
                </p>
            </div>
            <div class="grid-col">
                <figure>
                    <img src="/storage/images/homepage/image2.png" alt="" width="1000" height="1000" loading="lazy" decoding="async">
                </figure>
            </div>
        </div>
    </section>

    <section id="home-section-3" class="home-section">
        <div class="grid">
            <div class="grid-col">
                <h2 class="title is-4">⭐ {{ _('Benefits') }}</h2>
                <ol>
                    <li>{!! _('<strong>Help others</strong> to get useful information about games!') !!}</li>
                    <li>{!! _('Let the developers know <strong>why you like or do not like their games</strong>: this will contribute to improve the game itself, and <strong>spread awareness</strong> of bugs and features!') !!}</li>
                    <li>{!! _('Players reading your reviews might want to say their own thoughts about the game, and this will <strong>make the community grow</strong>!') !!}</li>
                    <li>{!! _('Last but not least, you can <strong>help small and less known games to rise up from the shadows</strong> and build interest around them!') !!}</li>
                </ol>
                <p class="buttons mt-6 is-centered">
                    <a href="{{ route('developers.index') }}" rel="nofollow" class="button is-medium is-link">
                        <span class="icon is-small">
                            <i class="fas fa-code"></i>
                        </span>
                        <span>{{ _('Browse developers') }}</span>
                    </a>
                    <a href="{{ route('publishers.index') }}" rel="nofollow" class="button is-medium is-link">
                        <span class="icon is-small">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </span>
                        <span>{{ _('Browse publishers') }}</span>
                    </a>
                    <a href="{{ route('platforms.index') }}" rel="nofollow" class="button is-medium is-link">
                        <span class="icon is-small">
                            <i class="fa-solid fa-desktop"></i>
                        </span>
                        <span>{{ _('Browse platforms') }}</span>
                    </a>
                </p>
            </div>
            <div class="grid-col">
                <figure>
                    <img src="/storage/images/homepage/image3.png" alt="" width="1000" height="1000" loading="lazy" decoding="async">
                </figure>
            </div>
        </div>
    </section>

    <section id="home-section-4" class="home-section">
        <div class="grid">
            <div class="grid-col">
                <h2 class="title is-4">🫂 {{ _('Contribute') }}</h2>
                <p>{{ _('') }}</p>
                <p class="mb-3">{!! _('We have already imported a <strong>long list</strong> of games, developers and publishers!') !!}</p>
                <p class="mb-3">{!! _('Of course that is not enough, so we would like your help in making our platform a <strong>better place</strong>.') !!}</p>
                <p class="mb-3">{!! _('Adding new games, developers, publishers, improving the text and images, and helping us finding mistakes: that is where you can help!') !!}</p>
                <p class="mb-3">{!! _('Moreover, being this an <strong>open source</strong> project, you can help by participating on <strong>Github</strong>!') !!}</p>
                <p>{!! _('Otherwise, simply support us with a <strong>donation</strong>!') !!}</p>
                <p class="buttons mt-6 is-centered">
                    <a href="https://github.com/eartahhj/GameAdvisor" rel="external noopener" target="_blank" class="button is-medium is-success">
                        <span class="icon is-medium">
                            <i class="fab fa-github"></i>
                        </span>
                        <span>{{ _('Github') }}</span>
                    </a>
                    <a href="{{ route('pages.show', 1) }}" class="button is-medium is-success" rel="nofollow">
                        <span class="icon is-medium">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        </span>
                        <span>{{ _('Donate') }}</span>
                    </a>
                </p>
            </div>
            <div class="grid-col">
                <figure>
                    <img src="/storage/images/homepage/image4.png" alt="" width="1000" height="1000" loading="lazy" decoding="async">
                </figure>
            </div>
        </div>
    </section>

    @if (!$latestReviews->isEmpty())
    <section id="home-latest-reviews" class="home-section p-6">
        <h2 class="title is-4">
            {{ _('Latest reviews') }} (<a href="{{ route('reviews.index') }}" rel="nofollow">{{ _('All reviews')}}</a>)
        </h2>
        <ul class="grid reviews-list">
            @foreach ($latestReviews as $review)
                <x-reviews.list-item :review="$review" :image="$review->getImage()" />
            @endforeach
        </ul>
        <p class="mt-3">
            <a href="{{ route('reviews.index') }}" class="button is-info is-medium" rel="nofollow">
                <span class="icon is-small">
                    <i class="fas fa-eye"></i>
                </span>
                <span>{{ _('See all reviews') }}</span>
            </a>
        </p>
    </section>
    @endif


    @if (!$games->isEmpty())
    <section id="home-latest-games" class="home-section p-6">
        <h2 class="title is-4">
            {{ _('Latest games') }} (<a href="{{ route('games.index') }}" rel="nofollow">{{ _('All games')}}</a>)
        </h2>
        <ul class="items-list grid grid-mobile games-list">
            @foreach ($games as $game)
            <x-games.list-item :game="$game"/>
            @endforeach
        </ul>
        <p class="mt-6">
            <a href="{{ route('games.index') }}" class="button is-info is-medium" rel="nofollow">
                <span class="icon is-small">
                    <i class="fas fa-gamepad"></i>
                </span>
                <span>{{ _('See all games') }}</span>
            </a>
        </p>
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
