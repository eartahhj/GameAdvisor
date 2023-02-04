@extends('layouts.base')

@section('title') {{ _('Edit page') }} @endsection

@section('content')

<section class="template-default template-admin">
    <div class="container">

        <x-flash-message />

        <div class="box">
            <h1 class="title is-2"><?=_('Edit page')?></h1>

            <?= view('pages/form-edit', compact('page')) ?>

            <div class="mt-2">
                <?= view('pages/form-delete', compact('page')) ?>
            </div>

            <div class="mt-2">
                <?= view('pages/form-publish', compact('page')) ?>
            </div>
        </div>
    </div>
</section>

@endsection