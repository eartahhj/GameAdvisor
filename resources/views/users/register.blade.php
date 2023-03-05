@extends('layouts.base')

@section('content')
<section class="template-default template-register">
    <div class="container">
        <x-flash-message />

        <h1 class="title is-2">{{ $pageTitle }}</h1>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        @if (session()->has('confirm') and auth()->user())
            <x-registration-success />
        @elseif (auth()->user())
            <x-registration-already-registered />
        @endif
    
        @if (auth()->user())
            <p class="buttons">
                <x-button-bulma class="is-primary">
                    <x-slot:text>{{ _('Browse games') }}</x-slot>
                    <x-slot:link>{{ route('games.index') }}</x-slot>
                </x-button-bulma>
                <x-button-bulma class="is-warning">
                    <x-slot:text>{{ _('Logout') }}</x-slot>
                    <x-slot:link>{{ route('users.logout') }}</x-slot>
                </x-button-bulma>
            </p>
        @else
            <form action="{{ route('users.register.register')}}" method="post">
                @csrf
                <div class="field">
                    <label for="user-registration-name" class="label">{{ _('Name') }}</label>
                    @error('name')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <input id="user-registration-name" type="text" name="name" value="{{ old('name') }}" class="input" autocomplete="name">
                </div>
    
                <div class="field">
                    <label for="user-registration-email" class="label">{{ _('Email') }} {{ _('*') }}</label>
                    @error('email')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <input id="user-registration-email" type="email" name="email" value="{{ old('email') }}" class="input" required="required" autocomplete="email">
                </div>
    
                <div class="field">
                    @error('password')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label for="user-registration-password" class="label">{{ _('Password') }} {{ _('*') }}</label>
                    <input id="user-registration-password" type="password" name="password" value="{{ old('password') }}" class="input" required="required" autocomplete="new-password">
                </div>
    
                <div class="field">
                    @error('password_confirmation')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label for="user-registration-password-confirmation" class="label">{{ _('Confirm password') }} {{ _('*') }}</label>
                    <input id="user-registration-password-confirmation" type="password" name="password_confirmation" value="{{ old('password') }}" class="input" required="required" autocomplete="new-password">
                </div>
    
                <button type="submit" name="send" class="button is-primary">{{ _('Register') }}</button>
            </form>
            <p>{{ _('Already registered?') }} <a href="{{ route('users.login.form') }}">{{ _('Login') }}</a></p>
        @endif
    </div>
</section>

@endsection
