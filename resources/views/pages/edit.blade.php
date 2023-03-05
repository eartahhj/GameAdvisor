@extends('layouts.base')

@section('content')
<section class="template-default template-admin">
    <div class="container">

        <x-flash-message />

        <div class="box">
            <x-page-title :text="$pageTitle"></x-page-title>

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