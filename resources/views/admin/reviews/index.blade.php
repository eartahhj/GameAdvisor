@extends('layouts.base')

@section('content')
<section class="template-default template-admin">
    <div class="container">
        <x-flash-message />

        <x-page-title :text="$pageTitle"></x-page-title>

        <?php if ($reviews->isEmpty()): ?>
            <h2><?= _('No reviews to show at the moment.') ?></h2>
        <?php else:?>
            <ul id="reviews-list" class="items-list grid grid-mobile reviews-list">
            <?php foreach ($reviews as $review):?>
                <li class="<?= ($review->approved ? 'background-success' : 'background-warning') ?>">
                    <x-reviews.list-item :review="$review"/>
                </li>
            <?php endforeach ?>
            </ul>
        <?php endif ?>
    </div>
</section>

@endsection