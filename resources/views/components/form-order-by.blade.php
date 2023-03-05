<label class="label" for="order-by">{{ _('Order by') }}</label>
<div class="select">
    <select name="order" id="order-by">
        @foreach ($options as $value => $label)
            <option value="{{ $value }}"{{ (!empty($_GET['order']) and $_GET['order'] == $value) ? ' selected="selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>