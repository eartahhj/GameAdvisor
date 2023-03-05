@extends('layouts.base')

@section('content')
<section class="template-default template-platforms">
    <div class="container">
        <x-flash-message />
        
        @if ($platforms->isEmpty())
            <p class="title is-3">{{ $pageTitle }}</p>
            <p class="mb-4">{{ _('Could not find what you are looking for?') }} <a href="{{ route('datarequests.create') }}">{{ _('Send us a request') }}</a> {{ sprintf(_('so that we can add the missing %s.'), _('platform')) }}</p>
        @else
            <x-page-title :text="$pageTitle"></x-page-title>
        @endif

        <form action="{{ route('platforms.index') }}" method="get" role="search" class="form-inline mb-4">
            <div class="grid-col">
                <x-form-order-by :options="$orderByOptions"></x-form-order-by>
            </div>
            <div class="grid-col">
                <x-form-search-base :action="route('platforms.index')" :searchValue="$searchValue" :searchName="$searchName">
                </x-form-search-base>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary">
                    {{ _('Filter') }}
                </button>
            </div>
        </form>

        @if (!$platforms->isEmpty())
        <ul class="items-list grid grid-mobile platforms-list">
        @foreach ($platforms as $platform)
            <x-platforms.list-item :platform="$platform"/>
        @endforeach
        </ul>
        @endif
    </div>
</section>

@endsection
