<?php
use App\Models\Game;
use App\Models\Page;
use App\Models\Platform;
use App\Models\Developer;
use App\Models\Publisher;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push(_('GameAdvisor'), route('index'));
});

Breadcrumbs::for('reviews.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Reviews'), route('reviews.index'));
});

Breadcrumbs::for('reviews.show', function (BreadcrumbTrail $trail) {
    $trail->parent('reviews.index');
    $trail->push(_('Review'));
});

Breadcrumbs::for('reviews.create', function (BreadcrumbTrail $trail) {
    $trail->parent('reviews.index');
    $trail->push(_('Write a review'));
});

Breadcrumbs::for('games.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Games'), route('games.index'));
});

Breadcrumbs::for('games.show', function (BreadcrumbTrail $trail, Game $game) {
    $trail->parent('games.index');
    $trail->push($game->title);
});

Breadcrumbs::for('platforms.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Platforms'), route('platforms.index'));
});

Breadcrumbs::for('platforms.show', function (BreadcrumbTrail $trail, Platform $platform) {
    $trail->parent('platforms.index');
    $trail->push($platform->name);
});

Breadcrumbs::for('developers.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Platforms'), route('developers.index'));
});

Breadcrumbs::for('developers.show', function (BreadcrumbTrail $trail, Developer $developer) {
    $trail->parent('developers.index');
    $trail->push($developer->name);
});

Breadcrumbs::for('publishers.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Publishers'), route('publishers.index'));
});

Breadcrumbs::for('publishers.show', function (BreadcrumbTrail $trail, Publisher $publisher) {
    $trail->parent('publishers.index');
    $trail->push($publisher->name);
});

Breadcrumbs::for('user.review.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('reviews.index');
    $trail->push(_('Edit your review'));
});

Breadcrumbs::for('users.register.form', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Register'));
});

Breadcrumbs::for('users.login.form', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Login'));
});

Breadcrumbs::for('pages.show', function (BreadcrumbTrail $trail, $pageUrl) {
    $page = getPageByUri($pageUrl);
    $trail->parent('index');
    $trail->push($page->title);
});

Breadcrumbs::for('datarequests.create', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push(_('Send a request'));
});