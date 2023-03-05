@extends('layouts.base')

@section('content')
<section class="template-default template-user">
    <div class="container">
        <x-flash-message />

        <h1 class="title is-2">{{ $pageTitle }}</h1>
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
        
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
                <button type="submit" name="send" class="button is-primary">
                    <span class="icon">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </span>
                    <span>{{ _('Reset password') }}</span>
                </button>
            </div>
        </form>
        <p class="mt-2">{{ _('Not registered?') }} <a href="{{ route('users.register.form')}}"> {{ _('Create an account') }}</a></p>
    </div>
</section>

@endsection
