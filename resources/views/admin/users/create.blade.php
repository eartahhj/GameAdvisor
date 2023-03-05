@extends('layouts.base')

@section('content')
<section class="template-default template-admin">
    <div class="container">
        <x-flash-message />

        <h1 class="title is-2">{{ $pageTitle }}</h1>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('admin.users.store')}}" method="post">
            @csrf
            <div class="field">
                @error('name')
                <x-form-error>
                    <x-slot:text>
                    {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="user-create-name" class="label">{{ _('Name') }}</label>
                <input id="user-create-name" type="text" name="name" value="{{ old('name') }}" class="input" required="required" autocomplete="name" placeholder="{{ _('Full name') }}">
            </div>

            <div class="field">
                @error('password')
                <x-form-error>
                    <x-slot:text>
                    {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="user-create-password" class="label">{{ _('Password') }}</label>
                <input id="user-create-password" type="text" name="password" value="{{ old('password') }}" class="input" required="required" autocomplete="new-password" placeholder="{{ _('Password') }}">
            </div>

            <div class="field">
                @error('email')
                <x-form-error>
                    <x-slot:text>
                    {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="user-create-email" class="label">{{ _('Email') }}</label>
                <input id="user-create-email" type="text" name="email" value="{{ old('email') }}" class="input" required="required" autocomplete="email" placeholder="{{ _('Email') }}">
            </div>

            <fieldset>
                <legend class="label">{{ _('Admin')}}</legend>
                <div class="field">
                    @error('is_admin', 'is_superadmin')
                    <x-form-error>
                        <x-slot:text>
                            {{ $message }}
                            </x-slot>
                    </x-form-error>
                    @enderror
                    <label for="user-create-is_admin" class="checkbox">
                        <input id="user-create-is_admin" type="checkbox" name="is_admin" value="1" class="" {!! old('is_admin') ? ' checked="checked"' : '' !!}>
                        {{ _('Admin') }}
                    </label>

                    <label for="user-create-is_superadmin" class="checkbox">
                        <input id="user-create-is_superadmin" type="checkbox" name="is_superadmin" value="1" class="" {!! old('is_superadmin') ? ' checked="checked"' : '' !!}>
                        {{ _('Superadmin') }}
                    </label>
                </div>
            </fieldset>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>

    </div>
</section>

@endsection