@extends('layouts.base')

@section('title') {{ _('Login') }} @endsection

@section('content')
<section class="template-default template-user">
    <div class="container">
        <p class="title is-3">{{ _('Login') }}</p>
        <p class="mt-2 mb-2">
            <strong>GameAdvisor</strong> is still a <strong>Work-in-Progress</strong> project. If you want to know when it will be released, please create an account. Thank you!
        </p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        @if (auth()->user())
            <p>{{ _('You are already logged in.') }}</p>
            <p><a href="{{ route('users.dashboard') }}">{{ sprintf(_('Go to your %s'), _('dashboard')) }}</a></p>
        @else
            <form action="{{ route('users.login.form') }}" method="post">
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
                    <input id="user-login-email" type="email" name="email" value="" class="input" required="required" autocomplet="email">
                </div>
    
                <div class="field">
                    @error('password')
                        <x-form-error>
                            <x-slot:text>
                                {{ $message }}
                            </x-slot>
                        </x-form-error>
                    @enderror
                    <label for="user-login-password" class="label">{{ _('Password') }} {{ _('*') }}</label>
                    <input id="user-login-password" type="password" name="password" value="" class="input" required="required" autocomplete="current-password">
                </div>
    
                <div class="buttons">
                    <button type="submit" name="send" class="button is-primary">{{ _('Login') }}</button>
                    <a href="{{ route('users.forgottenpassword.form') }}" class="button is-warning">{{ _('Reset password') }}</a>
                </div>
            </form>
            <p class="mt-3">{{ _('Not registered?') }} <a href="{{ route('users.register.form')}}"> {{ _('Create an account') }}</a></p>
        @endif
    </div>
</section>

@endsection
