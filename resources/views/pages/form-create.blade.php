<form action="{{ route('pages.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    
    <?php foreach (config('app')['languages'] as $langCode => $lang):?>
    <fieldset>
        <legend><?= $lang ?></legend>

        <div class="field">
            @error('title_' . $langCode)
            <x-form-error>
                <x-slot:text>
                    {{ $message }}
                    </x-slot>
            </x-form-error>
            @enderror
            <label class="label" for="page-title_<?=$langCode?>"><?= sprintf(_('Title (%s)'), $lang) ?> <?=_('*')?></label>
            <div class="control has-icons-left has-icons-right">
                <input type="text" class="input" name="title_<?=$langCode?>" id="page-title_<?=$langCode?>" value="<?=old("title_{$langCode}")?>" minlength="5" maxlength="200" required="required" placeholder="" autocomplete="off">
                <span class="icon is-small is-left">
                    <i class="fas fa-bullhorn"></i>
                </span>
            </div>
            <p class="help"><?=_('The title of the page should be below 60 characters')?></p>
        </div>

        <div class="field">
            @error('html_' . $langCode)
            <x-form-error>
                <x-slot:text>
                {{ $message }}
                </x-slot>
            </x-form-error>
            @enderror
            <label class="label" for="page-html_<?=$langCode?>"><?= sprintf(_('HTML (%s)'), $lang) ?> <?=_('*')?></label>
            <div class="control">
                <textarea class="tinymce" id="page-html_<?=$langCode?>" name="html_<?=$langCode?>" cols="30" rows="10"><?=old("html_{$langCode}", '')?></textarea>
            </div>
            <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
        </div>

        <div class="field">
            @error('url_' . $langCode)
            <x-form-error>
                <x-slot:text>
                {{ $message }}
                </x-slot>
            </x-form-error>
            @enderror
            <label class="label" for="page-url_<?=$langCode?>"><?= sprintf(_('URL (%s)'), $lang) ?></label>
            <div class="control has-icons-left has-icons-right">
                <input type="text" class="input" name="url_<?=$langCode?>" id="page-url_<?=$lang?>" value="<?=old("url_{$langCode}")?>" minlength="5" maxlength="200" placeholder="" inputmode="text" autocomplete="off">
                <span class="icon is-small is-left">
                    <i class="fas fa-bullhorn"></i>
                </span>
            </div>
            <p class="help"><?=_('The URL should be lowercase and separated by dashes, not spaces nor underscores')?></p>
        </div>
    </fieldset>
    <?php endforeach?>

    <div class="buttons mt-5">
        <button type="submit" class="button is-success"><?=_('Save')?></button>
    </div>
</form>