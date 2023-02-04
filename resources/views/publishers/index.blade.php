@extends('layouts.base')

@section('title') {{ _('Publishers') }} @endsection

@section('content')
<section class="template-default template-publishers">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">
            @if ($publishers->isEmpty())
                {{ _('No publishers to show at the moment.') }}
            @else
                @if (empty($searchName))
                    {{ _('All publishers') }}
                @else
                    {{ sprintf(_('All publishers for: %s'), $searchName) }}
                @endif
            @endif
        </p>

        <form action="{{ route('publishers.index') }}" method="get" role="search">
            <span>{{ _('Search by name:') }}</span>
            <span>
                <input type="search" class="input" name="name" value="{{ $searchName }}">
            </span>
            <span>
                <button type="submit" class="button is-primary" name="search">{{ _('Search') }}</button>
            </span>
        </form>

        @if (!$publishers->isEmpty())
        <ul class="items-list grid grid-mobile games-list">
            @foreach ($publishers as $publisher)
                <x-publishers.list-item :publisher="$publisher"/>
            @endforeach
        </ul>
        @endif
    </div>
</section>

@endsection
