<form method="post" action="{{ route('reviews.approve', $review->id) }}">
    @csrf
    <input type="hidden" name="_method" value="PUT" />
    <input type="hidden" name="id" value="<?= $review->id ?>">
    <?php if ($review->approved): ?>
        <input type="hidden" name="unapprove" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really unapprove this review?') ?>')" class="button is-warning"><?= _('Unapprove this review') ?></button>
    <?php else: ?>
        <input type="hidden" name="approve" value="1">
        <button type="submit" onclick="return confirm('<?= _('Really approve this review?') ?>')" class="button is-success"><?= _('Approve this review') ?></button>
    <?php endif ?>
</form>