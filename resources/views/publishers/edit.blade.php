@extends('layouts.base')

@section('title') {{ _('Edit publisher') }} @endsection

@section('content')
<section class="template-default template-publishers">
    <div class="container">
        <x-flash-message />
    
        <x-page-title :text="$pageTitle"></x-page-title>
        <p class="title is-5">{{ sprintf(_('Publisher: %s'), $publisher->name) }}</p>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('publishers.update', $publisher) }}" method="post" enctype="multipart/form-data" id="form-edit">
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
                        <input type="text" class="input" name="name_<?=$langCode?>" id="name_<?=$langCode?>" value="<?=old("name_{$langCode}", $publisher->{'name_' . $langCode})?>" minlength="5" maxlength="200" required="required" placeholder="" autocomplete="off">
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
                        <textarea class="textarea" id="description_<?=$langCode?>" name="description_<?=$langCode?>" cols="30" rows="10"><?=old("description_{$langCode}", $publisher->{'description_' . $langCode})?></textarea>
                    </div>
                    <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
                </div>
            </fieldset>
            @endforeach

            <x-form-image-field name="logo" :help="$supportedImageFormats" :image="$image" :filename="$publisher->logo"></x-form-image-field>
        </form>
    
        <form action="{{ route('publishers.delete', $publisher) }}" method="post" id="form-delete">
            @csrf
            @method('DELETE')
        </form>
    
        <div class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <a href="{{ route('publishers.create') }}" class="button is-primary" form="form-edit">
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
