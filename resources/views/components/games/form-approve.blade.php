<form method="post" action="{{ route('games.approve', $game->id) }}">
    @csrf
    <input type="hidden" name="_method" value="PUT" />
    <?php if ($game->approved): ?>
        <input type="hidden" name="unapprove" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really unapprove this game?') ?>')" class="button is-warning"><?= _('Unapprove this game') ?></button>
    <?php else: ?>
        <input type="hidden" name="approve" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really approve this game?') ?>')" class="button is-success"><?= _('Approve this game') ?></button>
    <?php endif ?>
</form>