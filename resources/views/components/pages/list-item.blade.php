<article>
    <h2>
        <a href="<?= route('pages.edit', $page) ?>">
        {{ $page->{'title_' . $locale} }}
        </a>
        (<a href="<?= page_url($page->id) ?>"><?= _('View this page') ?></a>)
    </h2>
    <p><?= sprintf(_('Published: %s'), $page->published ? _('Yes') : _('No')) ?></p>

    <?php if ($authUser->is_superadmin):?>
    <?= view('pages/form-publish', compact('page')) ?>
    <?php endif?>
</article>