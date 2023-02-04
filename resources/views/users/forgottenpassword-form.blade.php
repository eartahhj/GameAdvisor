@extends('layouts.base')

@section('title') {{ _('Reset password') }} @endsection

@section('content')
<section class="template-default template-user">
    <div class="container">
        <p class="title is-3">{{ _('Reset password') }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form action="{{ route('users.forgottenpassword') }}" method="post">
            @csrf
    
            <div class="field">
                @error('email')
                    <x-form-error>
                        <x-slot:text>
                            {{ $message }}
                        </x-slot>
                    </x-form-error>
                @enderror
                <label for="user-login-email" class="label">{{ _('Email') }} {{ _('*') }}</label>
                <input id="user-login-email" type="email" name="email" value="{{ old('email') }}" class="input" required="required" autocomplete="email">
            </div>
    
            <div class="buttons">
                <button type="submit" name="send" class="button is-primary">{{ _('Reset password') }}</button>
            </div>
        </form>
        <p>{{ _('Not registered?') }} <a href="{{ route('users.register.form')}}"> {{ _('Create an account') }}</a></p>
    </div>
</section>

@endsection
