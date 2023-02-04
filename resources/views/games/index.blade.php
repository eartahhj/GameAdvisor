@extends('layouts.base')

@section('title') {{ _('Games') }} @endsection

@section('content')
<section class="template-default template-games">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">
            @if ($games->isEmpty())
                {{ _('No games to show at the moment.') }}
            @else
                @if (!empty($platform))
                    {{ sprintf(_('All games for: %s'), $platform->name) }}
                @elseif (!empty($searchTitle))
                    {{ sprintf(_('All games for: %s'), $searchTitle) }}
                @else
                    {{ _('All games') }}
                @endif
            @endif
        </p>

        
        <form action="{{ route('games.index') }}" method="get" role="search">
            @if (!empty($platforms) and !$platforms->isEmpty())
            <span>{{ _('Filter by:') }}</span>
            <span>
                <select name="platform">
                    <option value="">{{ _('Choose platform') }}</option>
                    @foreach ($platforms as $platformData)
                        <option value="{{ $platformData->id }}"{{ ($platformData->id == $platformId ? ' selected="selected"' : '') }}>{{ $platformData->name }}</option>
                    @endforeach
                </select>
            </span>
            @endif
            <span>{{ _('Search title:') }}</span>
            <span>
                <input type="search" class="input" name="title" value="{{ $searchTitle }}">
            </span>
            <span>
                <button type="submit" class="button is-primary" name="search">{{ _('Search') }}</button>
            </span>
        </form>
       

        <ul class="items-list grid grid-mobile games-list">
            @foreach ($games as $game)
                <x-games.list-item :game="$game"/>
            @endforeach
        </ul>

        @if ($games->links())
            <nav class="pager">
                {{ $games->onEachSide(3)->links() }}
            </nav>
        @endif
    </div>
</section>

@endsection
