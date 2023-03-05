<fieldset>
    <legend class="label">{{ _('Rating') }} {{ _('*') }}</legend>

    <div id="rating-radiolist" class="field">
        @error('rating')
        <x-form-error :text="$message"></x-form-error>
        @enderror

        <div class="control radiolist">
            @for ($i = 1; $i <= 5; $i++)
                <input id="reviews-edit-rating-{{$i}}" type="radio" name="rating" value="{{$i}}"{{ ($currentRating == $i ? ' checked="checked"' : '')}} tabindex="0" class="sr-only" aria-labelledby="radio-rating-{{$i}}-label" required="required">
            @endfor

            <div class="labels">
                @for ($i = 1; $i <= 5; $i++)
                    <label id="radio-rating-{{$i}}-label" class="radio radio-rating-{{$i}}" for="reviews-edit-rating-{{$i}}" tabindex="-1">
                        <span class="radiolist-radio-label sr-only">{{$i}} {{ ($i == 1 ? _('star') : _('stars')) }}</span>
                    </label>
                @endfor
            </div>
        </div>
    </div>
</fieldset>