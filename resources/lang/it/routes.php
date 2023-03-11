<?php
return [
    'reviews' => 'recensioni',
    'reviews.{review}' => 'recensioni/{review}',
    'reviews.{review}.edit' => 'recensioni/{review}/modifica',
    'reviews.store.{game}' => 'recensioni/salva/{game}',
    'reviews.create.{game}' => 'recensioni/crea/{game}',
    'reviews.update' => 'recensioni/{review}',
    'reviews.delete' => 'recensioni/elimina',
    'reviews.game.{game}' => 'recensioni/gioco/{game}',
    'reviews.choose.game' => 'recensioni/scegli-gioco/{platform?}',
    'reviews.{review}.approve' => 'recensioni/{review}/approva',

    'games' => 'giochi',
    'games.{game}.edit' => 'giochi/{game}/modifica',
    'games.{game}' => 'giochi/{game}',
    'games.update' => 'giochi/{game}',
    'games.delete' => 'giochi/elimina',
    'games.store' => 'giochi/salva',
    'games.create' => 'giochi/crea',
    'games.platform.{id}' => 'giochi/piattaforma/{id}',

    'users' => 'utenti',
    'users.show.{user}' => 'utenti/{user}',
    'users.register' => 'registrati',
    'users.login.auth' => 'login',
    'users.login.form' => 'login',
    'users.logout' => 'esci',
    'users.dashboard' => 'cruscotto',
    'users.forgottenpassword' => 'password-dimenticata',
    'users.forgottenpassword.form' => 'password-dimenticata',
    'users.resetpassword' => 'reimposta-password',
    'users.resetpassword.{token}' => 'reimposta-password/{token}',
    'users.email.verification.notice' => 'verifica-email',
    'users.email.verification.verify.{id}.{hash}' => 'verifica-email/{id}/{hash}',
    'users.email.verification.resend' => 'verifica-email/reinvia',

    'user.profile' => 'profilo',
    'user.update' => 'profilo/aggiorna',
    'user.myReviews' => 'le-mie-recensioni',
    'user.changePassword' => 'cambia-password',
    'user.review.{review}' => 'utente/recensione/{review}',
    'user.review.{review}.edit' => 'utente/recensione/{review}/modifica',

    'platforms' => 'piattaforme',
    'platforms.{platform}.edit' => 'piattaforme/{platform}/modifica',
    'platforms.{platform}' => 'piattaforme/{platform}',
    'platforms.update' => 'piattaforme/{platform}',
    'platforms.delete' => 'piattaforme/elimina',
    'platforms.store' => 'piattaforme/salva',
    'platforms.create' => 'piattaforme/crea',

    'developers' => 'sviluppatori',
    'developers.{developer}.edit' => 'sviluppatori/{developer}/modifica',
    'developers.{developer}' => 'sviluppatori/{developer}',
    'developers.update' => 'sviluppatori/{developer}',
    'developers.delete' => 'sviluppatori/elimina',
    'developers.store' => 'sviluppatori/salva',
    'developers.create' => 'sviluppatori/crea',

    'publishers' => 'publishers',
    'publishers.{publisher}.edit' => 'editori/{publisher}/modifica',
    'publishers.{publisher}' => 'editori/{publisher}',
    'publishers.update' => 'editori/{publisher}',
    'publishers.delete' => 'editori/elimina',
    'publishers.store' => 'editori/salva',
    'publishers.create' => 'editori/crea',

    'pages.{page}.edit' => 'pagine/{page}/modifica',
    'pages.{page}' => 'pagine/{page}',
    'pages.update' => 'pagine/{page}',
    'pages.delete' => 'pagine/elimina',
    'pages.store' => 'pagine/salva',
    'pages.create' => 'pagine/crea',
    'pages.{page}.publish' => 'pagine/{page}/pubblica',

    'datarequests.create' => 'richiedi',
    'datarequests.store' => 'richiedi',

    'admin.index' => 'amministrazione/cruscotto',

    'admin.reviews.index' => 'amministrazione/recensioni',

    'admin.platforms.index' => 'amministrazione/piattaforme',

    'admin.publishers.index' => 'amministrazione/editori',

    'admin.games.index' => 'amministrazione/giochi',

    'admin.developers.index' => 'amministrazione/sviluppatori',

    'admin.pages.{page}' => 'amministrazione/pagine/{page}',
    'admin.pages.index' => 'amministrazione/pagine',

    'admin.users.index' => 'amministrazione/utenti',
    'admin.users.{user}' => 'amministrazione/utenti/{user}',
    'admin.users.create' => 'amministrazione/utenti/crea',
    'admin.users.{user}.edit' => 'amministrazione/utenti/{user}/modifica',
];
