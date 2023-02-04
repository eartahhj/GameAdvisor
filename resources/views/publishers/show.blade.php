@extends('layouts.base')

@section('title') {{ sprintf(_('Publisher: %s'), $publisher->name) }} @endsection

@section('content')
<section class="template-default template-publishers">
    <div class="container">
        <h2>{{ $publisher->name }}</h2>
    
        @if (!empty(auth()->user()->id))
            <p>
                <a href="{{ route('publishers.edit', $publisher) }}">{{ _('Edit') }}</a>
                <a href="{{ route('publishers.create') }}">{{ _('Create new') }}</a>
            </p>
    
            <form action="{{ route('publishers.delete', $publisher)}}" method="post">
                @csrf
                @method('DELETE')
    
                <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')">{{ _('Delete') }}</button>
            </form>
        @endif
    
        <p>
            <a href="{{ route('games.index') }}?publisher={{ $publisher->id }}" rel="nofollow">{{ _('See games by this publisher')}}</a>
        </p>
    </div>
</section>

@endsection
