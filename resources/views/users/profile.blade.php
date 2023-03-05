@extends('layouts.base')

@section('content')
<section class="template-default template-standard">
    <div class="container">
        <x-flash-message />
        
        <h1 class="title is-2">{{ $pageTitle }}</h1>

        @if ($user->private_profile)
        <x-messages.info>
            <x-slot:text>{{ _('By default your profile is private. You can change this by removing the corresponding flag below and saving the changes.'); }}</x-slot:text>
        </x-messages.info>
        @endif

        <dl class="mt-2">
            <dt><strong>{{ _('Name') }}</strong></dt>
            <dd>{{ $user->name }}</dd>
            <dt class="mt-2">
                <strong>{{ _('Profile visibility') }}</strong>
            </dt>
            <dd>{{ $user->private_profile ? _('Private profile') : _('Public profile') }}</dd>
        </dl>
        @if ($user->private_profile)
        <p class="help">{{ _('Private profile means that your profile will not have a public page to view on the website, so some of your information will not be disclosed. Your name and email will still be associated to your reviews, unless you make them anonymously.') }}</p>
        @else
        <p class="help">{{ _('Public profile means that your profile can be viewed, so some of your information will be disclosed. Your name and email will be associated to your reviews unless you make them anonymously.') }}</p>
        @endif

        <h2 class="title is-5 mt-5 mb-1">{{ _('Avatar') }}</h2>
        <figure>
            <img src="{{ $user->avatar() }}" alt="" width="100" height="100">
            <figcaption class="mt-2">
                <?= sprintf(_('You can change your avatar at %s'), '<a href="https://www.libravatar.org" rel="external noreferrer nofollow noopener" target="_blank">' . _('Libravatar') . '</a>') ?>
            </figcaption>
        </figure>

        <form id="form-change-profile" action="{{ route('user.update') }}" method="post" class="mt-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="_method" value="PUT">
            <div class="field">
                <label for="email" class="label">{{ _('Email') }}</label>
                @error('email')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <div class="control has-icons-left has-icons-right">
                    <input id="email" type="email" class="input" name="email" inputmode="email" autocomplete="email" placeholder="{{ _('Email address') }}" value="{{ old('email', $user->email) }}" required />
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                <p class="help">{{ _('If you change your email address, we will send you a new verification email to activate the new address.') }}</p>
            </div>

            <div class="field">
                <label for="bio" class="label">{{ _('Bio') }}</label>
                @error('bio')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <textarea id="bio" name="bio" rows="10" cols="40" class="textarea">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <fieldset>
                <legend class="label">{{ _('Private profile')}}</legend>
                <div class="field">
                    @error('private_profile')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label for="private_profile" class="checkbox">
                        <input id="private_profile" type="checkbox" name="private_profile" value="1" class="" {!! old('private_profile', $user->private_profile) ? ' checked="checked"' : '' !!}>
                        {{ _('Make my profile private') }}
                    </label>
                    <p class="help">{{ _('By removing the flag here, your profile will become public.') }}</p>
                </div>
            </fieldset>
        </form>

        <form id="form-delete-account" action="{{ route('user.deleteMyAccount') }}" method="post">
            @csrf
            @method('DELETE')
        </form>

        <p class="mt-5 buttons">
            <button type="submit" class="button is-primary" form="form-change-profile">
                <span class="icon is-small"><i class="fas fa-save"></i></span>
                <span>{{ _('Save info') }}</span>
            </button>
            <a href="{{ route('user.changePasswordView') }}" class="button is-link">
                <span class="icon is-small"><i class="fas fa-key"></i></span>
                <span>{{ _('Change your password') }}</span>
            </a>
            <button type="submit" class="button is-danger" form="form-delete-account" onclick="return confirm('Are you sure? All your data will be deleted, including your posts and uploaded images. This cannot be undone.')">
                <span class="icon is-small"><i class="fas fa-trash"></i></span>
                <span>{{ _('Delete your account') }}</span>
            </button>
        </p>
    </div>
</section>
@endsection