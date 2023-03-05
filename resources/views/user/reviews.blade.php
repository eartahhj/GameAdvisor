@extends('layouts.base')

@section('content')
<section class="template-default template-standard">
    <div class="container">
        <x-flash-message />
    
        <x-page-title :text="$pageTitle"></x-page-title>
        
        <p>
            @if ($reviews->isEmpty())
                {{ _('This user has not reviewed any game yet!') }}
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
