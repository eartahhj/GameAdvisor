@extends('layouts.base')

@section('content')
<section class="template-default template-publishers">
    <div class="container">
        <x-flash-message />

        @if ($publishers->isEmpty())
            <p class="title is-2">{{ $pageTitle }}</p>
            <p class="mb-4">{{ _('Could not find what you are looking for?') }} <a href="{{ route('datarequests.create') }}">{{ _('Send us a request') }}</a> {{ sprintf(_('so that we can add the missing %s.'), _('publisher')) }}</p>
        @else
            <x-page-title :text="$pageTitle"></x-page-title>
        @endif

        <form action="{{ route('publishers.index') }}" method="get" role="search" class="form-inline mb-4">
            <div class="grid-col">
                <x-form-order-by :options="$orderByOptions"></x-form-order-by>
            </div>
            <div class="grid-col">
                <x-form-search-base :action="route('publishers.index')" :searchValue="$searchValue" :searchName="$searchName">
                </x-form-search-base>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary">
                    {{ _('Filter') }}
                </button>
            </div>
        </form>

        @if (!$publishers->isEmpty())
        <ul class="items-list grid grid-mobile publishers-list">
            @foreach ($publishers as $publisher)
            <x-publishers.list-item :publisher="$publisher" :logo="$publisher->getLogo()" />
            @endforeach
        </ul>
        @endif

        @if ($publishers->links())
        <nav class="pager mt-6">
            {{ $publishers->onEachSide(3)->links() }}
        </nav>
        @endif
    </div>
</section>

@endsection
