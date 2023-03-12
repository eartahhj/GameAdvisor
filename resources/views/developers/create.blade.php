@extends('layouts.base')

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <x-flash-message />

        <h1 class="title is-2">{{ $pageTitle }}</h1>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('developers.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            
            @foreach(getLanguages() as $langCode => $langName)
            <fieldset class="improved">
                <legend><?= $langName ?></legend>
                <div class="field">
                    @error("name_$langCode")
                        <x-form-error>
                            <x-slot:text>
                            {{ $message }}
                        </x-slot>
                    </x-form-error>
                    @enderror
                    <label for="developer-name_{{ $langCode }}" class="label">{{ sprintf(_('Name (%s)'), $langName) }}{{ $langCode == 'en' ? ' ' . _('*') : '' }}</label>
                    <input id="developer-name_{{ $langCode }}" type="text" name="name_{{ $langCode }}" value="{{ old("name_$langCode") }}" class="input"{{ $langCode == 'en' ? ' required="required"' : '' }}>
                </div>
                <div class="field">
                    @error("description_$langCode")
                        <x-form-error>
                            <x-slot:text>
                            {{ $message }}
                        </x-slot>
                    </x-form-error>
                    @enderror
                    <label for="developer-description_{{ $langCode }}" class="label">{{ sprintf(_('Description (%s)'), $langName) }}</label>
                    <input id="developer-description_{{ $langCode }}" type="text" name="description_{{ $langCode }}" value="{{ old("description_$langCode") }}" class="input">
                </div>

                <div class="field">
                    @error('link_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="link_<?=$langCode?>"><?= sprintf(_('Link (%s)'), $langName) ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="url" class="input" name="link_<?=$langCode?>" id="link_<?=$langCode?>" value="<?=old("link_{$langCode}")?>" minlength="5" maxlength="200" placeholder="" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    </div>
                </div>
            </fieldset>
            @endforeach

            <div class="field">
                @error('image')
                <x-form-error>
                    <x-slot:text>{{ $message }}</x-slot>
                </x-form-error>
                @enderror
                <div class="control file is-link has-name is-fullwidth">
                    <label class="file-label" for="developer-logo">
                        <input class="file-input simp" type="file" name="logo" id="developer-logo" accept="image/*" data-preview-container-selector="#images-previews" data-names-container-selector="#file-names" />
                        <span class="file-cta">
                            <span class="file-icon">
                            <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                            <?= _('Choose image to upload') ?>
                            </span>
                        </span>
                        <span id="file-names" class="file-name">
                            <?= _('Browse...') ?>
                        </span>
                    </label>
                </div>
                <p class="help"><?= _('Supported Formats: JPEG, PNG, WEBP or AVIF. Dimensions: 800x600px. Maximum size: 800KB.') ?></p>
                <div id="images-previews" class="images-preview"></div>
            </div>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
