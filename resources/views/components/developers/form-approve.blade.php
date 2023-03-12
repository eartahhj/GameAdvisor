<form method="post" action="{{ route('developers.approve', $developer->id) }}">
    @csrf
    <input type="hidden" name="_method" value="PUT" />
    <?php if ($developer->approved): ?>
        <input type="hidden" name="unapprove" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really unapprove this developer?') ?>')" class="button is-warning"><?= _('Unapprove this developer') ?></button>
    <?php else: ?>
        <input type="hidden" name="approve" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really approve this developer?') ?>')" class="button is-success"><?= _('Approve this developer') ?></button>
    <?php endif ?>
</form>