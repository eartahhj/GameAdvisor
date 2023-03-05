@extends('layouts.base')

@section('content')
<section class="template-default template-standard">
    <div class="container">
        <x-flash-message />
        
        <x-page-title :text="$pageTitle"></x-page-title>

        <p class="mb-3"><?= _('All fields are mandatory.') ?></p>

        <form action="{{ route('user.changePasswordAction') }}" method="post">
            @csrf
            @method('PUT')
            <div class="field">
                <label class="label" for="user-password"><?=_('New password') ?> <?= _('*') ?></label>
                <div class="control has-icons-left has-icons-right">
                    @error('password')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <input type="password" name="password" id="user-password" class="input" inputmode="text" autocomplete="off" placeholder="<?= _('New password') ?>" required value="">
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label for="user-password_confirmation" class="label"><?= _('Confirm password') ?> <?= _('*') ?></label>
                <div class="control has-icons-left has-icons-right">
                    @error('password_confirmation')
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <input id="user-password_confirmation" type="password" class="input" name="password_confirmation" inputmode="text" autocomplete="off" placeholder="<?= _('Repeat the password') ?>" required value="" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="button is-primary">
                    <span class="icon">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text"><?= _('Change password') ?></span>
                </button>
            </div>
        </form>
    </div>
</section>
@endsection