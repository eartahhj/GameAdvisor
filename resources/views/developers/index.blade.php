@extends('layouts.base')

@section('title') {{ _('Developers') }} @endsection

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">
            @if ($developers->isEmpty())
                {{ _('No developers to show at the moment.') }}
            @else
                @if (empty($searchName))
                    {{ _('All developers') }}
                @else
                    {{ sprintf(_('All developers for: %s'), $searchName) }}
                @endif
            @endif
        </p>

        <form action="{{ route('developers.index') }}" method="get" role="search">
            <span>{{ _('Search by name:') }}</span>
            <span>
                <input type="search" class="input" name="name" value="{{ $searchName }}">
            </span>
            <span>
                <button type="submit" class="button is-primary" name="search">{{ _('Search') }}</button>
            </span>
        </form>

        @if (!$developers->isEmpty())
        <ul class="items-list grid grid-mobile games-list">
            @foreach ($developers as $developer)
                <x-developers.list-item :developer="$developer"/>
            @endforeach
        </ul>
        @endif
    </div>
</section>

@endsection
