@extends('layouts.base')

@section('content')
<section class="template-default template-admin">
    <div class="container">
        <x-flash-message />
        
        <div class="box">
            <h1 class="title is-2">{{ $pageTitle }}</h1>

            <p class="buttons">
                <a href="<?= route('admin.users.create') ?>" class="button is-link"><?= _('New user') ?></a>
            </p>

            <?php if ($users->isEmpty()): ?>
                <h2><?= _('No users to show at the moment') ?></h2>
            <?php else:?>
                <ul id="users-list">
                <?php foreach ($users as $user):?>
                    <li class="<?= ($user->email_verified_at ? 'background-success' : 'background-warning') ?>">
                        <x-users.list-item :user="$user"/>
                    </li>
                <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
        
    </div>
</section>

@endsection