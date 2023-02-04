@extends('layouts.base')

@section('title') {{ sprintf(_('Platform: %s'), $platform->name) }} @endsection

@section('content')
<section class="template-default template-platforms">
    <div class="container">
        <h2>{{ $platform->name }}</h2>
    
        @if (!empty(auth()->user()->id))
            <p>
                <a href="{{ route('platforms.edit', $platform) }}">{{ _('Edit') }}</a>
                <a href="{{ route('platforms.create') }}">{{ _('Create new') }}</a>
            </p>
    
            <form action="{{ route('platforms.delete', $platform)}}" method="post">
                @csrf
                @method('DELETE')
    
                <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')">{{ _('Delete') }}</button>
            </form>
        @endif
    
        <p>
            <a href="{{ route('games.index') }}?platform={{ $platform->id }}" rel="nofollow">{{ _('See games for this platform')}}</a>
        </p>
    </div>
</section>

@endsection
