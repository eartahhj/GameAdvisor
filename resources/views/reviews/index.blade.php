@extends('layouts.base')

@section('title') {{ _('Reviews') }} @endsection

@section('content')
<section class="template-default template-reviews">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">
            @if ($reviews->isEmpty())
                @if (empty($game))
                    {{ _('No reviews to show at the moment.') }}
                @else
                    {{ sprintf(_('No reviews to show at the moment for: %s'), $game->title) }}
                @endif
            @else
                @if (empty($game))
                    {{ _('All reviews') }}
                @else
                    {{ sprintf(_('All reviews for: %s'), $game->title) }}
                @endif
            @endif
        </p>

        @if (!$reviews->isEmpty())
            <x-reviews.form-order-by>
                <x-slot:action>{{ route('reviews.index') }}</x-slot>
            </x-reviews.form-order-by>
            <ul class="items-list reviews-list">
                @foreach ($reviews as $review)
                    <x-reviews.list-item :review="$review"/>
                @endforeach
            </ul>

            @if (!empty($reviews->links()))
                <nav class="pager">
                    {{ $reviews->onEachSide(3)->links() }}
                </nav>
            @endif
        @endif
    </div>
</section>

@endsection
