@extends('layouts.base')

@section('content')
<section class="template-default template-user">
    <div class="container">
        <x-flash-message />

        <p class="title is-3">{{ _('Login') }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        @if (auth()->user())
            <p>{{ _('You are already logged in.') }}</p>
            <p><a href="{{ route('users.dashboard') }}">{{ sprintf(_('Go to your %s'), _('dashboard')) }}</a></p>
        @else
            <form action="{{ route('users.login.form') }}" method="post">
                @csrf
    
                <div class="field">
                    <label for="user-login-email" class="label">{{ _('Email') }} {{ _('*') }}</label>
                    @error('email')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <input id="user-login-email" type="email" name="email" value="" class="input" required="required" autocomplet="email">
                </div>
    
                <div class="field">
                    <label for="user-login-password" class="label">{{ _('Password') }} {{ _('*') }}</label>
                    @error('password')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <input id="user-login-password" type="password" name="password" value="" class="input" required="required" autocomplete="current-password">
                </div>
    
                <div class="buttons">
                    <button type="submit" name="send" class="button is-primary">
                        <span class="icon">
                            <i class="fa-solid fa-right-to-bracket"></i>
                        </span>
                        <span>{{ _('Login') }}</span>
                    </button>
                    <a href="{{ route('users.forgottenpassword.form') }}" class="button is-warning">
                        <span class="icon">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                        </span>
                        <span>{{ _('Reset password') }}</span>
                    </a>
                </div>
            </form>
            <p class="mt-3">{{ _('Not registered?') }} <a href="{{ route('users.register.form')}}"> {{ _('Create an account') }}</a></p>
        @endif
    </div>
</section>

@endsection
