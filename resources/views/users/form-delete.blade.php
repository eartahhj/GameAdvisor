<form method="post" action="{{ route('admin.users.delete', $user) }}">
    @csrf
    <input type="hidden" name="_method" value="DELETE" />
    <button type="submit" onclick="return confirm('<?= _('Really delete this user?') ?>')" class="button is-danger"><?= _('Delete this user') ?></button>
</form>