<div class="field">
    @error($name)
    <x-form-error>
        <x-slot:text>
            {{ $message }}
            </x-slot>
    </x-form-error>
    @enderror
    
    <div class="control file is-link has-name is-fullwidth">
        <label class="file-label" for="{{ $name }}">
            <input class="file-input simp" type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*" data-preview-container-selector="#images-previews" data-names-container-selector="#file-names" />
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
    
    @isset($help)
    <p class="help">{{ $help }}</p>
    @endisset

    <div id="images-previews" class="images-preview"></div>
    @isset ($filename, $image)
    <p>{{ _('Current file:') }}</p>
    <figure>
        <img src="/storage/{{ $filename }}" alt="" width="{{ $image->width() }}" height="{{ $image->height() }}">
    </figure>
    <p><a href="/storage/{{ $filename }}">{{ _('View file') }}</a></p>
    @endisset
</div>