<label for="filter-by" class="label">{{ _('Rating') }}</label>
<div class="select">
    <select name="rating" id="filter-by-rating">
        <option value="">{{ _('Rating') }}</option>
        @foreach ($ratings as $rating => $label)
        <option value="{{ $rating }}"{{ ($rating == intval($_GET['rating'] ?? 0) ? ' selected="selected"' : '') }}>{{ $label }}</option>
        @endforeach
    </select>
</div>