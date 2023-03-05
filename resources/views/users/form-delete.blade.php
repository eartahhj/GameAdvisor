<form method="post" action="{{ route('admin.users.delete', $user) }}">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('<?= _('Really delete this user?') ?>')" class="button is-danger"><?= _('Delete this user') ?></button>
</form>