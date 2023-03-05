@extends('layouts.base')

@section('content')
<section class="template-default template-reviews">
    <div class="container">
        <x-flash-message />

        @if ($reviews->isEmpty())
            <p class="title is-2">{{ $pageTitle }}</p>
        @else
            <h1 class="title is-2">{{ $pageTitle }}</h1>
        @endif

        <form class="form-inline mb-4" action="{{ route('reviews.index') }}" method="get" class="filter">
            <div class="col">
                <x-form-order-by :options="$orderByOptions" action="{{ route('reviews.index') }}"></x-form-order-by>
            </div>
            <div class="col">
                <x-form-filter-platforms :platforms="$platforms" action="{{ route('reviews.index') }}" :platformId="$platformId"></x-form-filter-platforms>
            </div>
            <div class="col">
                <x-form-filter-ratings :ratings="$ratings" action="{{ route('reviews.index') }}"></x-form-filter-ratings>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary">
                    {{ _('Filter') }}
                </button>
            </div>
        </form>

        <ul class="grid reviews-list">
            @foreach ($reviews as $review)
            <x-reviews.list-item :review="$review" :image="$review->getImage()" />
            @endforeach
        </ul>

        @if (!empty($reviews->links()))
        <nav class="pager">
            {{ $reviews->onEachSide(3)->links() }}
        </nav>
        @endif
    </div>
</section>

@endsection
