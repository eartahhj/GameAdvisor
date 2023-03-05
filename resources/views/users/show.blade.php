@extends('layouts.base')

@section('content')
<section class="template-default template-user">
    <div class="container">
        <div class="grid grid-7-3">
            <div class="grid-col">
                <x-page-title :text="$pageTitle"></x-page-title>

                @if ($user->name or $user->bio)
                <article class="mb-4">
                    @if ($user->bio)
                    <div id="user-bio">{{ sprintf(_('Bio: %s'), $user->bio) }}</div>
                    @endif
                </article>
                @endif

                @if ($reviews and !$reviews->isEmpty())
                    <h2 class="title is-5">{{ _('Reviews by this user') }}</h2>
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
                @endif
            </div>

            <aside>
                @if ($user->avatar())
                <figure>
                    <img src="{{ $user->avatar() }}" alt="" width="48" height="48">
                </figure>
                @endif

                <dl>
                    @if ($numberOfReviews)
                    <dt>{{ _('Reviews') }}</dt>
                    <dd>{{ $numberOfReviews }}</dd>
                    @endif
                </dl>
            </aside>
        </div>
    
        @if (auth()->user() and auth()->user()->is_superadmin)
        <p class="mt-6 mb-6">
            <x-button-bulma link="{{ route('admin.users.edit', $user) }}" text="{{ _('Edit') }}" class="is-warning"></x-button-bulma>
        </p>
        @endif
    </div>
</section>

@endsection
