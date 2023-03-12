@extends('layouts.base')

@section('content')
<section class="template-default template-games">
    <div class="container">
        <x-flash-message />
    
        <x-page-title :text="$pageTitle"></x-page-title>
        <p class="title is-5">{{ sprintf(_('Game: %s'), $game->title) }}</p>
        
        @if ($errors->any())
            @include('forms.errors', ['class' => 'is-danger', 'text' => _('Errors found')])
        @endif
    
        <form action="{{ route('games.update', $game) }}" method="post" enctype="multipart/form-data" id="form-edit">
            @csrf
            @method('PUT')

            @foreach(getLanguages() as $langCode => $langName)
            <fieldset class="improved">
                <legend><?= $langName ?></legend>

                <div class="field">
                    @error('title_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    
                    <label class="label" for="title_<?=$langCode?>"><?= sprintf(_('Title (%s)'), $langName) ?> <?=_('*')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="text" class="input" name="title_<?=$langCode?>" id="title_<?=$langCode?>" value="<?=old("title_{$langCode}", $game->{'title_' . $langCode})?>" minlength="5" maxlength="200" required="required" placeholder="" autocomplete="off">
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
                        <textarea class="tinymce" id="description_<?=$langCode?>" name="description_<?=$langCode?>" cols="30" rows="10">{!! old("description_{$langCode}", $game->{'description_' . $langCode}) !!}</textarea>
                    </div>
                    <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
                </div>

                <div class="field">
                    @error('link_' . $langCode)
                    <x-form-error :text="$message"></x-form-error>
                    @enderror
                    <label class="label" for="link_<?=$langCode?>"><?= sprintf(_('Link (%s)'), $langName) ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="url" class="input" name="link_<?=$langCode?>" id="link_<?=$langCode?>" value="<?=old("link_{$langCode}", $game->{'link_' . $langCode})?>" minlength="5" maxlength="200" placeholder="" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    </div>
                </div>
            </fieldset>
            @endforeach
    
            <div class="field">
                @error('platform_id')
                <x-form-error :text="$message"></x-form-error>
                @enderror
                <label for="games-edit-platform" class="label">{{ _('Platform') . ' ' . _('*') }}</label>
                <select id="games-edit-platform" name="platform_id" required="required" class="chosen">
                    <option value="">{{ _('Select') }}</option>
                    @foreach ($platforms as $platform)
                    <option value="{{ $platform->id }}"{{ ($platform->id == $game->platform_id ? ' selected="|selected' : '') }}>{{ $platform->name }}</option>
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
                    <option value="{{ $developer->id }}"{{ ($developer->id == $game->developer_id ? ' selected="|selected' : '') }}>{{ $developer->name }}</option>
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
                    <option value="{{ $publisher->id }}"{{ ($publisher->id == $game->publisher_id ? ' selected="|selected' : '') }}>{{ $publisher->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-form-image-field name="image" :help="$supportedImageFormats" :image="$image" :filename="$game->image"></x-form-image-field>
        </form>
        
        <form action="{{ route('games.delete', $game) }}" method="post" id="form-delete">
            @csrf
            @method('DELETE')
        </form>

        <x-games.form-approve :game="$game" />
    
        <div class="buttons">
            <button type="submit" name="send" class="button is-primary" form="form-edit">
                <span class="icon is-small"><i class="fas fa-check"></i></span>
                <span>{{ _('Save') }}</span>
            </button>
            <a href="{{ route('games.create') }}" class="button is-primary">
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
