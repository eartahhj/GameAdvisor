@extends('layouts.base')

@section('content')
<section class="template-default template-standard">
    <div class="container">
        <x-flash-message />

        <x-page-title :text="$pageTitle"></x-page-title>

        <p class="mb-3">{{ _('We have tried to add as much data as possible to give you a more useful portal, but of course we might have missed many information.') }}</p>
        <p class="mb-3">{{ _('For example you could request us to add games, platforms, publishers and developers.') }}</p>
        <p class="mb-6">{{ _('The fields marked with an asterisk are mandatory.') }}</p>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('datarequests.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <x-honeypot />
            <div class="field">
                @error('title')
                <x-form-error><x-slot:text :message="$message"></x-slot></x-form-error>
                @enderror
                <label for="create-type" class="label">{{ _('Type of request') }} {{ _('*') }}</label>
                <p class="control select is-dark">
                    <select name="type" id="create-type" required="required">
                        <option value="">{{ _('Select') }}</option>
                        @foreach ($requestTypes as $i => $type)
                        <option value="{{ $i }}"{{ old('type') == $i ? ' selected="selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </p>
                <p class="help">{{ _('What kind of data should we add?') }}</p>
            </div>

            <div class="field">
                @error('title')
                <x-form-error><x-slot:text :message="$message"></x-slot></x-form-error>
                @enderror
                <label for="create-title" class="label">{{ _('Title') }} {{ _('*') }}</label>
                <p class="control has-icons-left has-icons-right">
                    <input id="create-title" type="text" name="title" value="{{ old('title', '') }}" class="input" required="required" maxlength="150">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-question"></i>
                    </span>
                </p>
                <p class="help">{{ _('Please write the title of the data to add, like the name of the game or publisher that is missing.') }}</p>
            </div>

            <div class="field">
                @error('description')
                <x-form-error><x-slot:text :message="$message"></x-slot></x-form-error>
                @enderror
                <label for="create-description" class="label">{{ _('Description') }}</label>
                <p class="control">
                    <textarea id="reviews-create-text" name="description" rows="10" cols="40" class="textarea" required="required" minlength="10" maxlength="2000">{{ old('description', '') }}</textarea>
                </p>
                <p class="help">{{ _('We would appreciate a more detailed description, for example you could provide us some links. It can be short, just to help us out a bit.') }}</p>
            </div>

            <div class="field">
                @error('email')
                <x-form-error><x-slot:text :message="$message"></x-slot></x-form-error>
                @enderror
                <label for="create-email" class="label">{{ _('Email') }}</label>
                <p class="control has-icons-left has-icons-right">
                    <input id="create-email" type="email" name="email" value="{{ old('email', '') }}" class="input">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                </p>
                <p class="help">{{ _('If you want you can write an email to receive an update about your request.') }}</p>
            </div>

            <div class="field">
                @error('notes')
                <x-form-error><x-slot:text :message="$message"></x-slot></x-form-error>
                @enderror
                <label for="create-notes" class="label">{{ _('Notes') }}</label>
                <p class="control has-icons-left has-icons-right">
                    <input id="create-notes" type="text" name="notes" value="{{ old('notes', '') }}" class="input" minlength="5" maxlength="500">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-pencil"></i>
                    </span>
                </p>
                <p class="help">{{ _('In case you want to add some notes about your request.') }}</p>
            </div>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
