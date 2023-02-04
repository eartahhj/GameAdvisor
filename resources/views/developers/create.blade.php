@extends('layouts.base')

@section('title') {{ _('New developer') }} @endsection

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <x-flash-message />

        <h1>{{ _('Insert a new developer') }}</h1>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('developers.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field">
                @error('name')
                    @include('forms.message', ['class' => 'is-danger', 'text' => _('Error:') . ' ' . $message])
                @enderror
                <label for="developer-create-name" class="label">{{ _('Name') }}</label>
                <input id="developer-create-name" type="text" name="name" value="{{ old('name') }}" class="input" required="required">
            </div>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
