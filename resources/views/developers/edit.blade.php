@extends('layouts.base')

@section('content')
<section class="template-default template-developers">
    <div class="container">
        <x-flash-message />

        <x-page-title :text="$pageTitle"></x-page-title>
        <p class="title is-5">{{ sprintf(_('Developer: %s'), $developer->name) }}</p>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('developers.update', $developer) }}" method="post" enctype="multipart/form-data" id="form-edit">
            @csrf
            @method('PUT')
    
            @foreach(getLanguages() as $langCode => $langName)
            <fieldset class="improved">
                <legend><?= $langName ?></legend>

                <div class="field">
                    @error('name_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    
                    <label class="label" for="name_<?=$langCode?>"><?= sprintf(_('Name (%s)'), $langName) ?> <?=_('*')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="text" class="input" name="name_<?=$langCode?>" id="name_<?=$langCode?>" value="<?=old("name_{$langCode}", $developer->{'name_' . $langCode})?>" minlength="5" maxlength="200" required="required" placeholder="" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    @error('description_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="description_<?=$langCode?>"><?= sprintf(_('Description (%s)'), $langName) ?> <?=_('*')?></label>
                    <div class="control">
                        <textarea class="textarea" id="description_<?=$langCode?>" name="description_<?=$langCode?>" cols="30" rows="10"><?=old("description_{$langCode}", $developer->{'description_' . $langCode})?></textarea>
                    </div>
                    <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
                </div>

                <div class="field">
                    @error('link_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="link_<?=$langCode?>"><?= sprintf(_('Link (%s)'), $langName) ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="url" class="input" name="link_<?=$langCode?>" id="link_<?=$langCode?>" value="<?=old("link_{$langCode}", $developer->{'link_' . $langCode})?>" minlength="5" maxlength="200" placeholder="" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    </div>
                </div>
            </fieldset>
            @endforeach

            <x-form-image-field name="logo" :help="$supportedImageFormats" :image="$image" :filename="$developer->logo"></x-form-image-field>
        </form>
    
        <form action="{{ route('developers.delete', $developer) }}" method="post" id="form-delete">
            @csrf
            @method('DELETE')
        </form>

        <x-developers.form-approve :developer="$developer" />
    
        <div class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <a href="{{ route('developers.create') }}" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-plus"></i></span>
                <span>{{ _('Create new') }}</span>
            </a>
            <button type="submit" name="delete" onclick="return confirm('{{ _('Are you sure you want to delete this record?') }}')" class="button is-danger" form="form-delete">
                <span class="icon is-small"><i class="fas fa-trash"></i></span>
                <span>{{ _('Delete') }}</span>
            </button>
        </div>
    </div>
</section>

@endsection
