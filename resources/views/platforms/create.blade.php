@extends('layouts.base')

@section('content')
<section class="template-default template-platforms">
    <div class="container">
        <x-page-title :text="$pageTitle"></x-page-title>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form action="{{ route('platforms.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            
            @foreach(getLanguages() as $langCode => $langName)
            <div class="field">
                @error("name_$langCode")
                <x-form-error>
                    <x-slot:text>{{ $message }}</x-slot>
                </x-form-error>
                @enderror
                <label for="platform-name_{{ $langCode }}" class="label">{{ sprintf(_('Name (%s)'), $langName) }}{{ $langCode == 'en' ? ' ' . _('*') : '' }}</label>
                <input id="platform-name_{{ $langCode }}" type="text" name="name_{{ $langCode }}" value="{{ old("name_$langCode") }}" class="input"{{ $langCode == 'en' ? ' required="required"' : '' }}>
            </div>
            <div class="field">
                @error("description_$langCode")
                    <x-form-error>
                        <x-slot:text>
                        {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="platform-description_{{ $langCode }}" class="label">{{ sprintf(_('Description (%s)'), $langName) }}</label>
                <input id="platform-description_{{ $langCode }}" type="text" name="description_{{ $langCode }}" value="{{ old("description_$langCode") }}" class="input" required="required">
            </div>
            @endforeach

            <div class="field">
                @error('image')
                <x-form-error>
                    <x-slot:text>{{ $message }}</x-slot>
                </x-form-error>
                @enderror
                <div class="control file is-link has-name is-fullwidth">
                    <label class="file-label" for="platform-image">
                        <input class="file-input simp" type="file" name="image" id="platform-image" accept="image/*" data-preview-container-selector="#images-previews" data-names-container-selector="#file-names" />
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
