@extends('layouts.base')

@section('title') {{ _('Change your password') }} @endsection

@section('content')
<section class="template-default template-user">
    <div class="container">
        <p class="title is-3">{{ _('Change your password') }}</p>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form action="{{ route('users.resetpassword')}}" method="post">
            @csrf
    
            <div class="field">
                @error('email')
                    <x-form-error>
                        <x-slot:text>
                            {{ $message }}
                        </x-slot>
                    </x-form-error>
                @enderror
                <label for="user-resetpassword-email" class="label">{{ _('Email') }} {{ _('*') }}</label>
                <input id="user-resetpassword-email" type="email" name="email" value="{{ old('email') }}" class="input" required="required" autocomplete="email">
            </div>
    
            <div class="field">
                @error('password')
                    <x-form-error>
                        <x-slot:text>
                            {{ $message }}
                        </x-slot>
                    </x-form-error>
                @enderror
                <label for="user-resetpassword-password" class="label">{{ _('New password') }} {{ _('*') }}</label>
                <input id="user-resetpassword-password" type="password" name="password" value="" class="input" required="required" autocomplete="new-password">
            </div>
    
            <div class="field">
                @error('password_confirmation')
                    <x-form-error>
                        <x-slot:text>
                            {{ $message }}
                        </x-slot>
                    </x-form-error>
                @enderror
                <label for="user-resetpassword-password-confirmation" class="label">{{ _('Confirm new password') }} {{ _('*') }}</label>
                <input id="user-resetpassword-password-confirmation" type="password" name="password_confirmation" value="" class="input" required="required" autocomplete="new-password">
            </div>
    
            <input type="hidden" name="token" value="{{ $token }}">
    
            <button type="submit" name="send" class="button is-primary">{{ _('Reset password') }}</button>
        </form>
        <p><a href="{{ route('users.login.form') }}">{{ _('Login') }}</a></p>
        <p><a href="{{ route('users.register.form') }}">{{ _('Register') }}</a></p>
    </div>
</section>

@endsection
