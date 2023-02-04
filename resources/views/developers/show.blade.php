@extends('layouts.base')

@section('title') {{ sprintf(_('Developer: %s'), $developer->name) }} @endsection

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <h2>{{ $developer->name }}</h2>
    
        @if (!empty(auth()->user()->id))
            <p>
                <a href="{{ route('developers.edit', $developer) }}">{{ _('Edit') }}</a>
                <a href="{{ route('developers.create') }}">{{ _('Create new') }}</a>
            </p>
    
            <form action="{{ route('developers.delete', $developer)}}" method="post">
                @csrf
                @method('DELETE')
    
                <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')">{{ _('Delete') }}</button>
            </form>
        @endif
    
        <p>
            <a href="{{ route('games.index') }}?developer={{ $developer->id }}" rel="nofollow">{{ _('See games made by this developer')}}</a>
        </p>
    </div>
</section>

@endsection
