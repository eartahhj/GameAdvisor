<form method="post" action="{{ route('pages.delete', $page) }}">
    @csrf
    <input type="hidden" name="_method" value="DELETE" />
    <button type="submit" onclick="return confirm('<?= _('Really delete this page?') ?>')" class="button is-danger"><?= _('Delete this page') ?></button>
</form>