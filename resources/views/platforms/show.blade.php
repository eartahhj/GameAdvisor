@extends('layouts.base')

@section('content')
<section class="template-default template-platforms">
    <div class="container">
        <div class="grid grid-7-3">
            <article>
                <x-page-title :text="$pageTitle"></x-page-title>

                @if ($platform->description)
                <p>{{ $platform->description }}</p>
                @endif
            </article>

            <aside>
                @if ($platform->image and $image)
                <figure class="image">
                    <img src="/storage/{{ $platform->logo }}" alt="" width="{{ $logo->width() }}" height="{{ $logo->height() }}">
                </figure>
                @endif

                <dl>
                    @if ($numberOfGames)
                    <dt>{{ _('Games') }}</dt>
                    <dd>{{ $numberOfGames }}</dd>
                    @endif
                    @if ($platform->link)
                    <dt>{{ _('Wikipedia') }}</dt>
                    <dd>
                        <a href="{{ $platform->link }}" rel="external noopener noreferrer nofollow" target="_blank">{{ _('View on Wikipedia') }}</a>
                    </dd>
                    @endif
                </dl>
            </aside>
        </div>
    
        @if (auth()->user() and auth()->user()->is_superadmin)
        <p class="mt-6 mb-6">
            <x-button-bulma link="{{ route('platforms.edit', $platform) }}" text="{{ _('Edit') }}" class="is-warning"></x-button-bulma>
            <x-button-bulma link="{{ route('platforms.create') }}" text="{{ _('Create new') }}" class="is-info"></x-button-bulma>
        </p>
        @endif
    
        <p>
            <a href="{{ route('games.index') }}?platform={{ $platform->id }}" rel="nofollow">{{ _('See games for this platform')}}</a>
        </p>
    </div>
</section>

@endsection
