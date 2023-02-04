@extends('layouts.base')

@section('title') {{ _('New platform') }} @endsection

@section('content')
<section class="template-default template-platforms">
    <div class="container">
        <h1>{{ _('Insert a new platform') }}</h1>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form action="{{ route('platforms.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field">
                @error('name')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error:') . ' ' . $message])
                @enderror
                <label for="games-create-name" class="label">{{ _('Name') }}</label>
                <input id="games-create-name" type="text" name="name" value="{{ old('name') }}" class="input" required="required">
            </div>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
