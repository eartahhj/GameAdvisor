<form method="post" action="{{ route('publishers.approve', $publisher->id) }}">
    @csrf
    <input type="hidden" name="_method" value="PUT" />
    <?php if ($publisher->approved): ?>
        <input type="hidden" name="unapprove" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really unapprove this publisher?') ?>')" class="button is-warning"><?= _('Unapprove this publisher') ?></button>
    <?php else: ?>
        <input type="hidden" name="approve" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really approve this publisher?') ?>')" class="button is-success"><?= _('Approve this publisher') ?></button>
    <?php endif ?>
</form>