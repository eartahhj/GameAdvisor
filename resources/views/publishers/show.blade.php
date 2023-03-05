@extends('layouts.base')

@section('content')
<section class="template-default template-publishers">
    <div class="container">
        <div class="grid grid-7-3">
            <article>
                <x-page-title :text="$pageTitle"></x-page-title>

                @if ($publisher->description)
                <p>{{ $publisher->description }}</p>
                @endif
            </article>

            <aside>
                @if ($publisher->logo and $logo)
                <figure class="image">
                    <img src="/storage/{{ $publisher->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $logo->height() }}">
                </figure>
                @endif

                <dl>
                    @if ($numberOfGames)
                    <dt>{{ _('Games') }}</dt>
                    <dd>{{ $numberOfGames }}</dd>
                    @endif
                    @if ($publisher->link)
                    <dt>{{ _('Wikipedia') }}</dt>
                    <dd>
                        <a href="{{ $publisher->link }}" rel="external noopener noreferrer nofollow" target="_blank">{{ _('View on Wikipedia') }}</a>
                    </dd>
                    @endif
                </dl>
            </aside>
        </div>
    
        @if (auth()->user() and auth()->user()->is_superadmin)
        <p class="mt-6 mb-6">
            <x-button-bulma link="{{ route('publishers.edit', $publisher) }}" text="{{ _('Edit') }}" class="is-warning"></x-button-bulma>
            <x-button-bulma link="{{ route('publishers.create') }}" text="{{ _('Create new') }}" class="is-info"></x-button-bulma>
        </p>
        @endif
    
        <p>
            <a href="{{ route('games.index') }}?publisher={{ $publisher->id }}" rel="nofollow">{{ _('See games by this publisher')}}</a>
        </p>
    </div>
</section>

@endsection
