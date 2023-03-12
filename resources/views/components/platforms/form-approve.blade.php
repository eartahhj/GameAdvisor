<form method="post" action="{{ route('platforms.approve', $platform->id) }}">
    @csrf
    <input type="hidden" name="_method" value="PUT" />
    <?php if ($platform->approved): ?>
        <input type="hidden" name="unapprove" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really unapprove this platform?') ?>')" class="button is-warning"><?= _('Unapprove this platform') ?></button>
    <?php else: ?>
        <input type="hidden" name="approve" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really approve this platform?') ?>')" class="button is-success"><?= _('Approve this platform') ?></button>
    <?php endif ?>
</form>