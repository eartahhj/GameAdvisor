@extends('layouts.base')

@section('title') {{ _('Manage pages') }} @endsection

@section('content')

<section class="template-default template-admin">
    <div class="container">
        <x-flash-message />
        
        <div class="box">
            <h1 class="title is-2"><?=_('Manage pages')?></h1>

            <p class="buttons">
                <a href="<?= route('pages.create') ?>" class="button is-link"><?= _('New page') ?></a>
            </p>

            <?php if ($pages->isEmpty()): ?>
                <h2><?= _('No pages to show at the moment') ?></h2>
            <?php else:?>
                <ul id="pages-list">
                <?php foreach ($pages as $page):?>
                    <li class="<?= ($page->published ? 'background-success' : 'background-warning') ?>">
                        <x-pages.list-item :page="$page"/>
                    </li>
                <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</section>

@endsection