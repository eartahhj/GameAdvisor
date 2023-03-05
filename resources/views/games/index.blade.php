@extends('layouts.base')

@section('content')
<section class="template-default template-games">
    <div class="container">
        <x-flash-message />

        @if ($games->isEmpty())
            <p class="title is-2">{{ $pageTitle }}</p>
            <p class="mb-4">{{ _('Could not find what you are looking for?') }} <a href="{{ route('datarequests.create') }}">{{ _('Send us a request') }}</a> {{ sprintf(_('so that we can add the missing %s.'), _('game')) }}</p>
        @else
            <x-page-title :text="$pageTitle"></x-page-title>
        @endif

        
        <form action="{{ route('games.index') }}" method="get" role="search" class="form-inline mb-4">
            <div class="grid-col">
                <x-form-order-by :options="$orderByOptions"></x-form-order-by>
            </div>
            <div class="grid-col">
                <x-form-filter-platforms :platforms="$platforms" :platformId="$platformId"></x-form-filter-platforms>          
            </div>
            <div class="grid-col">
                <x-form-search-base :action="route('games.index')" :searchValue="$searchValue" :searchName="$searchName">
                </x-form-search-base>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary">
                    {{ _('Filter') }}
                </button>
            </div>
        </form>

        <ul class="items-list grid grid-mobile games-list">
        @foreach ($games as $game)
            <x-games.list-item :game="$game"/>
        @endforeach
        </ul>

        @if ($games->links())
        <nav class="pager mt-6">
            {{ $games->onEachSide(3)->links() }}
        </nav>
        @endif
    </div>
</section>

@endsection
