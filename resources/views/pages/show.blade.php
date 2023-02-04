@extends('layouts.base')

@section('title') {{ $page->title }} @endsection

@section('content')
<section class="template-default template-standard">
    <div class="container">

        <?php if (!$page->published and $authUser and ($authUser->is_superadmin or $authUser->id == $page->user_creator_id)): ?>
            <div class="message is-warning">
                <div class="message-header"><?= _('Warning') ?></div>
                <div class="message-body"><?= _('This page has not been published yet, and is visible only to admins.') ?></div>
            </div>
        <?php endif?>

        <?php if ($authUser and ($authUser->is_superadmin or $authUser->id == $page->user_creator_id)): ?>
        <p class="buttons mb-5">
            <a href="<?= route('pages.edit', $page)?>" class="button is-link"><?= _('Edit this page') ?></a>
        </p>
        <?php endif?>

        <article class="text">
            <?= $page->{'html_' . $locale} ?>
        </article>
    </div>
</section>

@endsection
