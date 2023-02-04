@extends('layouts.base')

@section('title') {{ _('Administration panel') }} @endsection

@section('content')

<section id="panel-index" class="template-default template-admin">
    <div class="container">
        <x-flash-message />
        
        <div class="box">
            <h1 class="title is-3"><?=_('Administration panel')?></h1>

            <h2 class="title is-5"><?= _('Users') ?></h2>
            <ul>
                <li>
                    <a href="<?= route('admin.users.index') ?>"><?= _('Manage users') ?></a>
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