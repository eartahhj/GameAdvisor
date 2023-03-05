@extends('layouts.base')

@section('content')
<section class="template-default template-publishers">
    <div class="container">
        <x-page-title :text="$pageTitle"></x-page-title>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <x-flash-message />
    
        <form action="{{ route('publishers.store')}}" method="post" enctype="multipart/form-data">
            @csrf

            @foreach(getLanguages() as $langCode => $langName)
            <div class="field">
                @error("name_$langCode")
                    <x-form-error>
                        <x-slot:text>
                        {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="publisher-name_{{ $langCode }}" class="label">{{ sprintf(_('Name (%s)'), $langName) }}{{ $langCode == 'en' ? ' ' . _('*') : '' }}</label>
                <input id="publisher-name_{{ $langCode }}" type="text" name="name_{{ $langCode }}" value="{{ old("name_$langCode") }}" class="input"{{ $langCode == 'en' ? ' required="required"' : '' }}>
            </div>
            <div class="field">
                @error("description_$langCode")
                    <x-form-error>
                        <x-slot:text>
                        {{ $message }}
                    </x-slot>
                </x-form-error>
                @enderror
                <label for="publisher-description_{{ $langCode }}" class="label">{{ sprintf(_('Description (%s)'), $langName) }}</label>
                <input id="publisher-description_{{ $langCode }}" type="text" name="description_{{ $langCode }}" value="{{ old("description_$langCode") }}" class="input">
            </div>
            @endforeach

            <x-form-image-field name="logo" :help="$supportedImageFormats"></x-form-image-field>
    
            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
