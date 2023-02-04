<article>
    <h2>
        <a href="<?= route('admin.users.edit', $user) ?>">
        {{ $user->{'title_' . $locale} }}
        </a>
    </h2>
    <p><?= sprintf(_('Verified: %s'), !empty($user->email_verified_at) ? _('Yes') : _('No')) ?></p>

    <?php if ($authUser->is_superadmin):?>
    <?= view('users/form-delete', compact('user')) ?>
    <?php endif?>
</article>