@extends('layouts.base')

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <div class="grid grid-7-3">
            <article>
                <h1 class="title is-2">{{ $pageTitle }}</h1>

                @if ($developer->description)
                <p>{{ $developer->description }}</p>
                @endif
            </article>

            <aside>
                @if ($developer->logo and $logo)
                <figure class="image">
                    <img src="/storage/{{ $developer->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $logo->height() }}">
                </figure>
                @endif

                <dl>
                    @if ($numberOfGames)
                    <dt>{{ _('Games') }}</dt>
                    <dd>{{ $numberOfGames }}</dd>
                    @endif
                    @if ($developer->link)
                    <dt>{{ _('Wikipedia') }}</dt>
                    <dd>
                        <a href="{{ $developer->link }}" rel="external noopener noreferrer nofollow" target="_blank">{{ _('View on Wikipedia') }}</a>
                    </dd>
                    @endif
                </dl>
            </aside>
        </div>
    
        @if (auth()->user() and auth()->user()->is_superadmin)
        <p class="mb-6">
            <x-button-bulma link="{{ route('developers.edit', $developer) }}" text="{{ _('Edit') }}" class="is-warning"></x-button-bulma>
            <x-button-bulma link="{{ route('developers.create') }}" text="{{ _('Create new') }}" class="is-info"></x-button-bulma>
        </p>
        @endif
    
        <p>
            <a href="{{ route('games.index') }}?developer={{ $developer->id }}" rel="nofollow">{{ _('See games made by this developer')}}</a>
        </p>
    </div>
</section>

@endsection
