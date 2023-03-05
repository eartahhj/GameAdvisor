<label for="filter-by" class="label">{{ _('Platform') }}</label>
<div class="select">
    <select name="platform" id="filter-by">
        <option value="">{{ _('Choose platform') }}</option>
        @foreach ($platforms as $platformData)
        <option value="{{ $platformData->id }}"{{ ($platformData->id == $platformId ? ' selected="selected"' : '') }}>{{ $platformData->name }}</option>
        @endforeach
    </select>
</div>