@extends('layouts.base')

@section('title') {{ _('Platforms') }} @endsection

@section('content')
<section class="template-default template-platforms">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">
            @if ($platforms->isEmpty())
                {{ _('No platforms to show at the moment.') }}
            @else
                {{ _('All platforms') }}
            @endif
        </p>

        @if (!$platforms->isEmpty())
        <ul class="items-list grid grid-mobile games-list">
            @foreach ($platforms as $platform)
                <x-platforms.list-item :platform="$platform"/>
            @endforeach
        </ul>
        @endif
    </div>
</section>

@endsection
