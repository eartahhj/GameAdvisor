<?php
return [
    'reviews' => 'reviews',
    'reviews.{review}.edit' => 'reviews/{review}/edit',
    'reviews.create.{game}' => 'reviews/create/{game}',
    'reviews.game.{game}' => 'reviews/game/{game}',
    'reviews.choose.game' => 'reviews/choose-game/{platform?}',

    'games' => 'games',
    'games.{game}.edit' => 'games/{game}/edit',
    'games.{game}' => 'games/{game}',
    'games.create' => 'games/create',
    'games.platform.{id}' => 'games/platform/{id}',

    'users' => 'users',
    'users.register.register' => 'register',
    'users.register.form' => 'register',
    'users.login.auth' => 'login',
    'users.login.form' => 'login',
    'users.logout' => 'logout',
    'users.dashboard' => 'dashboard',
    'users.forgottenpassword' => 'forgotten-password',
    'users.forgottenpassword.form' => 'forgotten-password',
    'users.resetpassword' => 'reset-password',
    'users.resetpassword.{token}' => 'reset-password/{token}',
    'users.email.verification.notice' => 'verify-email',
    'users.email.verification.verify.{id}.{hash}' => 'verify-email/{id}/{hash}',
    'users.email.verification.resend' => 'verify-email/resend',

    'user.profile' => 'profile',    
    'user.myReviews' => 'my-reviews',

    'platforms' => 'platforms',
    'platforms.{platform}.edit' => 'platforms/{platform}/edit',
    'platforms.{platform}' => 'platforms/{platform}',
    'platforms.create' => 'platforms/create',

    'developers' => 'developers',
    'developers.{developer}.edit' => 'developers/{developer}/edit',
    'developers.{developer}' => 'developers/{developer}',
    'developers.create' => 'developers/create',

    'publishers' => 'publishers',
    'publishers.{publisher}.edit' => 'publishers/{publisher}/edit',
    'publishers.{publisher}' => 'publishers/{publisher}',
    'publishers.create' => 'publishers/create',

    'pages.{page}.edit' => 'pages/{page}/edit',
    'pages.{page}' => 'pages/{page}',
    'pages.create' => 'pages/create',
    'pages.{page}.publish' => 'pages/{page}/publish',

    'admin.index' => 'admin/dashboard',

    'admin.pages.{page}' => 'admin/pages/{page}',
    'admin.pages.index' => 'admin/pages',

    'admin.users.{user}' => 'admin/users/{user}',
    'admin.users.index' => 'admin/users',
    'admin.users.create' => 'admin/users/create',
    'admin.users.{user}.edit' => 'admin/users/{user}/edit',
];
