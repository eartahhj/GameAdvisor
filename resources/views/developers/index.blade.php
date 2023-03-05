@extends('layouts.base')

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <x-flash-message />

        @if ($developers->isEmpty())
            <p class="title is-3">{{ $pageTitle }}</p>
            <p class="mb-4">{{ _('Could not find what you are looking for?') }} <a href="{{ route('datarequests.create') }}">{{ _('Send us a request') }}</a> {{ sprintf(_('so that we can add the missing %s.'), _('developer')) }}</p>
        @else
            <x-page-title :text="$pageTitle"></x-page-title>
        @endif

        <form action="{{ route('developers.index') }}" method="get" role="search" class="form-inline mb-4">
            <div class="grid-col">
                <x-form-order-by :options="$orderByOptions"></x-form-order-by>
            </div>
            <div class="grid-col">
                <x-form-search-base :action="route('developers.index')" :searchValue="$searchValue" :searchName="$searchName">
                </x-form-search-base>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary">
                    {{ _('Filter') }}
                </button>
            </div>
        </form>

        @if (!$developers->isEmpty())
        <ul class="items-list grid grid-mobile developers-list">
        @foreach ($developers as $developer)
            <x-developers.list-item :developer="$developer"/>
        @endforeach
        </ul>
        @endif

        @if ($developers->links())
        <nav class="pager mt-6">
            {{ $developers->onEachSide(3)->links() }}
        </nav>
        @endif
    </div>
</section>

@endsection
