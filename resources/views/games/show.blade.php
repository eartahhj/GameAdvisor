@extends('layouts.base')

@section('title') {{ sprintf(_('Game: %s'), $game->title) }} @endsection

@section('content')
<section class="template-default template-games">
    <div class="container">
        <h2>{{ $game->title }}</h2>
    
        <p>{{ $game->description }}</p>
    
        @if ($developer)
            <p>{!! _(sprintf('Developed by: %s', '<a href="' . route('developers.show', $developer->id) . '">' . $developer->name . '</a>')) !!}</p>
        @endif
    
        @if ($publisher)
            <p>{!! _(sprintf('Published by: %s', '<a href="' . route('publishers.show', $publisher->id) . '">' . $publisher->name . '</a>')) !!}</p>
        @endif
    
        @if ($game->image and $image)
            <figure>
                <img src="/storage/{{ $game->image }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}">
            </figure>
        @endif
    
        @if (!empty(auth()->user()->id))
            <p>
                <a href="{{ route('games.edit', $game) }}">{{ _('Edit') }}</a>
                <a href="{{ route('games.create') }}">{{ _('Create new') }}</a>
            </p>
    
            <form action="{{ route('games.index', $game)}}" method="post">
                @csrf
                @method('DELETE')
    
                <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')">{{ _('Delete') }}</button>
            </form>
        @endif
    
        @if (!$reviews->isEmpty())
            <p class="title is-3">{{ sprintf(_('Reviews for %s'), $game->title) }}</p>
            <x-reviews.form-order-by>
                <x-slot:action>{{ route('games.show', $game->id) }}</x-slot>
            </x-reviews.form-order-by>
    
            <ul>
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
