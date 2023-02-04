@extends('layouts.base')

@section('title') {{ sprintf(_('Game: %s'), $review->title) }} @endsection

@section('content')

<section class="template-default template-reviews">
    <div class="container">
        <h2>{{ $review->title }}</h2>
        <a href="{{ route('reviews.show', $review->id)}}">{{ $review->title }}</a>
    </div>
</section>

@endsection
