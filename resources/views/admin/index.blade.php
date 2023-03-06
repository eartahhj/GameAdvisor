@extends('layouts.base')

@section('content')
<section id="panel-index" class="template-default template-admin">
    <div class="container">
        <x-flash-message />
        
        <div class="box">
            <h1 class="title is-3">{{ $pageTitle }}</h1>

            <h2 class="title is-5"><?= _('Games') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.games.index') ?>"><?= _('Manage games') ?></a>
                </li>
                <li>
                    <a href="<?= route('games.create') ?>"><?= _('Create game') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Platforms') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.platforms.index') ?>"><?= _('Manage platforms') ?></a>
                </li>
                <li>
                    <a href="<?= route('platforms.create') ?>"><?= _('Create platform') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Publishers') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.publishers.index') ?>"><?= _('Manage publishers') ?></a>
                </li>
                <li>
                    <a href="<?= route('publishers.create') ?>"><?= _('Create publisher') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Developers') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.developers.index') ?>"><?= _('Manage developers
                    ') ?></a>
                </li>
                <li>
                    <a href="<?= route('developers.create') ?>"><?= _('Create developer') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Users') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.users.index') ?>"><?= _('Manage users') ?></a>
                </li>
                <li>
                    <a href="<?= route('admin.users.create') ?>"><?= _('Create user') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Pages') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.pages.index') ?>"><?= _('Manage pages') ?></a>
                </li>
                <li>
                    <a href="<?= route('pages.create') ?>"><?= _('New page') ?></a>
                </li>
            </ul>
        </div>
    </div>
</section>

@endsection