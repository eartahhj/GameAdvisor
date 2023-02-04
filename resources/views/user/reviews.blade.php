@extends('layouts.base')

@section('title') {{ _('My reviews') }} @endsection

@section('content')

<section class="template-default template-dashboard">
    <div class="container">
        <x-flash-message />
    
        <h1 class="title is-3">{{ _('My reviews') }}</h1>
        <p>
            @if ($reviews->isEmpty())
                {{ _('You have not written any review yet!') }}
            @else
                <ul class="items-list reviews-list">
                @foreach ($reviews as $review)
                    <x-reviews.list-item :review="$review"/>
                @endforeach
                </ul>
            @endif
        </p>
    </div>
</section>

@endsection
