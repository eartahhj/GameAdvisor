@php
$options = [];
$options['date_desc'] = _('Newest first');
$options['author_asc'] = _('Author (A to Z)');
$options['author_desc'] = _('Author (Z to A)');
$options['rating_desc'] = _('Best rating first');
$options['rating_asc'] = _('Worst rating first');
@endphp
<form class="filter" action="{{ $action }}">
    <p class="title is-5">{{ _('Order by') }}</p>
    <div class="field">
        <select name="order" onchange="submit()">
            <option value="">{{ _('Oldest first') }}</option>
            @foreach ($options as $value => $label)
                <option value="{{ $value }}"{{ (!empty($_GET['order']) and $_GET['order'] == $value) ? ' selected="selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="sr-only">
        <button type="submit">{{ _('Change order') }}</button>
    </div>
</form>