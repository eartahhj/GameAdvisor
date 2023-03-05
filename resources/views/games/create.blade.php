@extends('layouts.base')

@section('content')
<section class="template-default template-games">
    <div class="container">
        <h1 class="title is-2">{{ $pageTitle }}</h1>

        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif

        <x-flash-message />

        <form action="{{ route('games.store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <?php foreach (config('app')['languages'] as $langCode => $lang):?>
            <fieldset>
                <legend><?= $lang ?></legend>

                <div class="field">
                    @error('title_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="title_<?=$langCode?>"><?= sprintf(_('Title (%s)'), $lang) ?> <?=_('*')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="text" class="input" name="title_<?=$langCode?>" id="title_<?=$langCode?>" value="<?=old("title_{$langCode}")?>" minlength="5" maxlength="200" required="required" placeholder="" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    @error('description_' . $langCode)
                    <x-form-error>
                        <x-slot:text>
                        {{ $message }}
                        </x-slot>
                    </x-form-error>
                    @enderror
                    <label class="label" for="description_<?=$langCode?>"><?= sprintf(_('HTML (%s)'), $lang) ?> <?=_('*')?></label>
                    <div class="control">
                        <textarea class="tinymce" id="description_<?=$langCode?>" name="description_<?=$langCode?>" cols="30" rows="10"><?=old("description_{$langCode}", '')?></textarea>
                    </div>
                    <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
                </div>
            </fieldset>
            <?php endforeach?>

            <div class="field">
                @error('platform_id')
                    @include('forms.message', ['class' => 'is-danger', 'text' =>  _('Error:') . ' ' . $message])
                @enderror
                <label for="games-create-platform" class="label">{{ _('Platform') . ' ' . _('*') }}</label>
                <select id="games-create-platform" name="platform_id" required="required">
                @foreach ($platforms as $platform)
                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
                </select>
            </div>

            <x-form-image-field name="image" :help="$supportedImageFormats"></x-form-image-field>

            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
