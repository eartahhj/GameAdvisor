@extends('layouts.base')

@section('content')
<section class="template-default template-user">
    <div class="container">
        <x-flash-message />

        <h1 class="title is-2">{{ $pageTitle }}</h1>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
        
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
    
            @if ($token)
            <input type="hidden" name="token" value="{{ $token }}">
            @endif
    
            <p class="buttons">
                <button type="submit" name="send" class="button is-primary">
                    <span class="icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <span>{{ _('Reset password') }}</span>
                </button>
                <a href="{{ route('users.login.form') }}" class="button is-link">
                    <span class="icon">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </span>
                    <span>{{ _('Login') }}</span>
                </a>
                <a href="{{ route('users.register.form') }}" class="button is-link">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <span>{{ _('Register') }}</span>
                </a>
            </p>
        </form>
    </div>
</section>

@endsection
