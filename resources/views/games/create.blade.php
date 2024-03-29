@extends('layouts.base')

@section('content')
<section class="template-default template-games">
    <div class="container">
        <x-page-title :text="$pageTitle"></x-page-title>

        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif

        <x-flash-message />

        <form action="{{ route('games.store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <?php foreach (config('app')['languages'] as $langCode => $lang):?>
            <fieldset class="improved">
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
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="description_<?=$langCode?>"><?= sprintf(_('HTML (%s)'), $lang) ?> <?=_('*')?></label>
                    <div class="control">
                        <textarea class="tinymce" id="description_<?=$langCode?>" name="description_<?=$langCode?>" cols="30" rows="10"><?=old("description_{$langCode}", '')?></textarea>
                    </div>
                    <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
                </div>

                <div class="field">
                    @error('link_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="link_<?=$langCode?>"><?= sprintf(_('Link (%s)'), $lang) ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="url" class="input" name="link_<?=$langCode?>" id="link_<?=$langCode?>" value="<?=old("link_{$langCode}")?>" minlength="5" maxlength="200" placeholder="" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    </div>
                </div>
            </fieldset>
            <?php endforeach?>

            <div class="field">
                @error('platform_id')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="games-create-platform" class="label">{{ _('Platform') . ' ' . _('*') }}</label>
                <select id="games-create-platform" name="platform_id" required="required" class="chosen">
                    <option value="">{{ _('Select') }}</option>
                    @foreach ($platforms as $platform)
                    <option value="{{ $platform->id }}"{{ ($platform->id == old('platform_id', null) ? ' selected="selected"' : '') }}>{{ $platform->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                @error('developer_id')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="games-developer" class="label">{{ _('Developer') . ' ' . _('*') }}</label>
                <select id="games-developer" name="developer_id" required="required" class="chosen">
                    <option value="">{{ _('Select') }}</option>
                    @foreach ($developers as $developer)
                    <option value="{{ $developer->id }}"{{ ($developer->id == old('developer_id', null) ? ' selected="selected"' : '') }}>{{ $developer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                @error('publisher_id')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="games-publisher" class="label">{{ _('Publisher') . ' ' . _('*') }}</label>
                <select id="games-publisher" name="publisher_id" required="required" class="chosen">
                    <option value="">{{ _('Select') }}</option>
                    @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}"{{ ($publisher->id == old('publisher_id', null) ? ' selected="selected"' : '') }}>{{ $publisher->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-form-image-field name="image" :help="$supportedImageFormats"></x-form-image-field>

            <button type="submit" name="send" class="button is-primary">{{ _('Save') }}</button>
        </form>
    </div>
</section>

@endsection
