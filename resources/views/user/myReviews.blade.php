@extends('layouts.base')

@section('content')
<section class="template-default template-dashboard">
    <div class="container">
        <x-flash-message />
    
        <x-page-title :text="$pageTitle"></x-page-title>

        <x-messages.info>
            <x-slot:text>{{ _('Please note that here you will see all your reviews, even those that have not been approved yet, but you will not find your anonymous reviews.'); }}</x-slot:text>
        </x-messages.info>

        <p>
            @if ($reviews->isEmpty())
                {{ _('You have not written any review yet!') }}
            @else
                <ul class="grid reviews-list">
                @foreach ($reviews as $review)
                    <x-reviews.list-item :review="$review" :image="$review->getImage()" />
                @endforeach
                </ul>
            @endif
        </p>
    </div>
</section>
@endsection
