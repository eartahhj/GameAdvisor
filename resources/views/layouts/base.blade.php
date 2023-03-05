<?php
try {
    $matomoTracker->doTrackPageView($pageTitle);
} catch (\Exception $e) {
    error_log($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            {{ $pageTitle }} - {{ env('APP_NAME') }}
        </title>
        <link rel="preload" href="{{ asset('css/bulma/bulma.min.css') }}" as="style">
        <link rel="preload" href="{{ asset('css/style.css') }}" as="style">
        <link rel="preload" href="/vendor/fontawesome/css/all.min.css" as="style">

        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

        <style media="screen" title="Default">
        @font-face {
            font-family:'Lexend';
            src:url('/css/fonts/lexend/Lexend-Regular.ttf') format('truetype'),
            font-weight:normal;
            font-style:normal;
            font-display:swap;
        }

        @font-face {
            font-family:'LexendSemibold';
            src:url('/css/fonts/lexend/Lexend-Semibold.ttf') format('truetype'),
            font-weight:normal;
            font-style:normal;
            font-display:swap;
        }

        @font-face {
            font-family:'LexendBold';
            src:url('/css/fonts/lexend/Lexend-Bold.ttf') format('truetype'),
            font-weight:normal;
            font-style:normal;
            font-display:swap;
        }
        </style>

        @if (!empty($templateStylesheets))
            @foreach ($templateStylesheets as $css)
                <link rel="preload" href="{{ asset($css) }}" as="style">
            @endforeach
        @endif

        @if (!empty($templateJavascripts))
            @foreach ($templateJavascripts as $js)
                <link rel="preload" href="{{ asset($js) }}" as="script">
            @endforeach
        @endif

        <link rel="stylesheet" href="/vendor/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/bulma/bulma.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" title="Default">
        @if (!empty($templateStylesheets))
            @foreach ($templateStylesheets as $css)
                <link rel="stylesheet" href="{{ asset($css) }}" title="Default">
            @endforeach
        @endif

        <script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/global.js')}}"></script>

        @if (!empty($templateJavascripts))
            @foreach ($templateJavascripts as $js)
                <script type="text/javascript" src="{{ asset($js) }}"></script>
            @endforeach
        @endif
        <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        // _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        _paq.push(['enableHeartBeatTimer', 15]);
        (function() {
        var u="https://matomo.gaminghouse.community/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '6']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
        </script>

        @if (env('APP_ENV') == 'production')
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6766935573967740" crossorigin="anonymous"></script>
        @endif
    </head>
    <body>

        <header id="header-main">
            <div class="container">
                <?php /*
                # Not sure to keep this, we will see in the future
                <input type="checkbox" id="animations-switch-handler" role="switch" tabindex="0" class="sr-only"<?= (true ? '' : ' checked="checked"')?> aria-labelled-by="animations-switch-handler-label">
                <label for="animations-switch-handler" class="sr-only" tabindex="-1">
                    <span class="turn-on">
                        <?= _('Turn on animations') ?>
                    </span>
                    <span class="turn-off">
                        <?= _('Turn off animations')?>
                    </span>
                </label>
                */
                ?>
                <div id="header-main-grid" class="grid">
                    {{-- <div class="logo has-animation" aria-controls="animations-switch"> --}}
                    <div class="logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/logo.png') }}" alt="<?= env('APP_NAME') ?>" width="64" height="64" />
                        </a>
                        <p><?= env('APP_NAME') ?></p>
                    </div>
                    <nav id="nav-main" class="navbar">
                        <div id="nav-main-container">
                            <input type="checkbox" id="navbar-main-handler" class="sr-only" tabindex="0">
                            <label for="navbar-main-handler" tabindex="-1">
                                <span class="icon is-medium"></span>
                                <span class="text"><?= _('Menu') ?></span>
                                <span class="sr-only"><?= _('(Open/close the menu)') ?></span>
                            </label>
                            <ul class="navbar-start">
                                @if (!auth()->user())
                                <x-nav-item :route="route('users.register.form')" :text="_('Register')" :routeName="'register'"></x-nav-item>
                                <x-nav-item :route="route('users.login.form')" :text="_('Login')" :routeName="'login'"></x-nav-item>
                                @endif
                                <x-nav-item :route="route('reviews.index')" :text="_('Reviews')" :routeName="'review'"></x-nav-item>
                                <x-nav-item :route="route('games.index')" :text="_('Games')" :routeName="'game'"></x-nav-item>
                                <x-nav-item :route="route('platforms.index')" :text="_('Platforms')" :routeName="'platform'"></x-nav-item>
                                <x-nav-item :route="route('developers.index')" :text="_('Developers')" :routeName="'developer'"></x-nav-item>
                                <x-nav-item :route="route('publishers.index')" :text="_('Publishers')" :routeName="'publisher'"></x-nav-item>
                            </ul>
                            <div id="nav-main-shadow" onclick="closeMainNavigation()"></div>
                        </div>
                        <div class="navbar-end">
                            <?php
                            /*
                            <div class="switch">
                                <fieldset>
                                    <legend><?= _('Animations') ?></legend>
                                    <label id="animations-switch-handler-label" for="animations-switch-handler" tabindex="-1" class="switch-handler-label">
                                        <span class="toggle">
                                            <span class="toggle-knob"></span>
                                        </span>
                                        <span class="off" aria-hidden="true"><?= _('Off') ?></span>
                                        <span class="on" aria-hidden="true"><?= _('On') ?></span>
                                    </label>
                                </fieldset>
                            </div>
                            */?>
                            <div class="dropdown">
                                <input id="nav-language-handler" type="checkbox" tabindex="0" class="sr-only" aria-haspopup="true" aria-controls="nav-language-dropdown">
                                <label for="nav-language-handler" tabindex="-1" class="dropdown-trigger">
                                    <span class="text"><?=_('Change language')?></span>
                                    <span class="icon"></span>
                                </label>
                                <div id="nav-language-dropdown" class="dropdown-menu">
                                    <x-languages-list class="dropdown-content" />
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        @if (Auth::check())
        <section id="navbar-auth" class="navbar">
            <div class="container">
                <input type="checkbox" id="navbar-auth-handler" class="sr-only" tabindex="0">
                <div id="navbar-auth-user" class="navbar-start">
                    <p>{{ sprintf(_('You are logged in as %s'), $authUser->name) }}</p>
                </div>
                <nav id="navbar-auth-user-menu" class="navbar-end">
                    <label for="navbar-auth-handler" tabindex="-1">
                        <span class="icon is-medium"></span>
                        <span class="text"><?= _('User menu') ?></span>
                        <span class="sr-only"><?= _('(Open/close the menu)') ?></span>
                    </label>
                    <ul class="navbar-brand">
                        <li>
                            <a href="<?= route('user.myReviews') ?>" class="navbar-item"><?= _('My reviews') ?></a>
                        </li>
                        <li>
                            <a href="<?= route('user.profile') ?>" class="navbar-item"><?= _('My profile') ?></a>
                        </li>
                        <li>
                            <a href="<?= route('user.changePasswordView') ?>" class="navbar-item"><?= _('Change password') ?></a>
                        </li>
                        <li>
                            <a href="<?= route('users.logout') ?>" class="navbar-item"><?= _('Logout') ?></a>
                        </li>
                        <?php if ($authUser->is_superadmin):?>
                            <li>
                                <a href="<?= route('admin.index') ?>" class="navbar-item"><?= _('Administration') ?></a>
                            </li>
                            <li>
                                <a href="<?= route('admin.games.index') ?>" class="navbar-item"><?= _('Manage games') ?></a>
                            </li>
                            <li>
                                <a href="<?= route('admin.platforms.index') ?>" class="navbar-item"><?= _('Manage platforms') ?></a>
                            </li>
                            <li>
                                <a href="<?= route('admin.developers.index') ?>" class="navbar-item"><?= _('Manage developers') ?></a>
                            </li>
                            <li>
                                <a href="<?= route('admin.publishers.index') ?>" class="navbar-item"><?= _('Manage publishers') ?></a>
                            </li>
                            <li>
                                <a href="<?= route('admin.pages.index') ?>" class="navbar-item"><?= _('Manage pages') ?></a>
                            </li>
                            <li>
                                <a href="<?= route('admin.users.index') ?>" class="navbar-item"><?= _('Manage users') ?></a>
                            </li>
                        <?php endif?>
                    </ul>
                </nav>
            </div>
        </section>
        @endif

        <div id="banner-global" class="banner">
            <figure>
                <img src="/storage/images/banners/banner{{ rand(1, 6) }}.png" alt="" width="1920" height="200">
            </figure>
        </div>

        <main id="main-content">
        @hasSection('alerts')
        <div id="page-alerts">
            @yield('alerts')
        </div>
        @endif

        @hasSection('breadcrumbs')
        <div id="page-breadcrumbs" class="container">
            <nav class="breadcrumb">
                @yield('breadcrumbs')
            </nav>
        </div>
        @else
            @unless(!Breadcrumbs::exists(request()->route()->getName()) or request()->route()->getName() == 'index')
            <div id="page-breadcrumbs" class="container">
                {{ Breadcrumbs::render() }}
            </div>
            @endunless
        @endif

        @hasSection('content')
        <div id="page-content">
            @yield('content')
        </div>
        @endif
        </main>

        @if (env('APP_ENV') == 'production')
        <div id="gads-bottom" class="gads">
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6766935573967740" data-ad-slot="8905929447" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        @endif

        <footer>
            <div class="container">
                <div class="grid">
                    <div id="footer-col-1" class="logo logo-smaller">
                        <a href="{{ route('index') }}">
                            <img src="/img/logo.png" alt="" width="64" height="64" />
                            <p class="mt-0 mb-0">{{ env('APP_NAME') }}</p>
                        </a>
                    </div>
                    <div id="footer-col-2" class="grid-col">
                        <nav class="languages-list">
                            <span class="title is-5"><?=_('Change language')?></span>
                            <x-languages-list />
                        </nav>
                        <nav id="footer-policies">
                            <h2 class="title is-5"><?= _('Policies') ?></h2>
                            <ul>
                                <li>
                                    <a href="<?= page_url(3) ?>"><?= _('Privacy policy') ?></a>
                                </li>
                                <li>
                                    <a href="<?= page_url(4) ?>"><?= _('Cookie policy') ?></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <nav id="footer-col-3" class="grid-col">
                        <ul>
                            <li>
                                <span class="icon is-large" aria-hidden="true">
                                    <i class="fab fa-github fa-3x"></i>
                                </span>
                                <a href="https://github.com/eartahhj/GameAdvisor" rel="external noopener" target="_blank">
                                    Github
                                    <span class="sr-only"><?= _('(opens in a new window)') ?></span>
                                </a>
                                <span class="icon is-small" aria-hidden="true">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </span>
                            </li>
                            <li>
                                <span class="icon icon-custom icon-donate is-large" aria-hidden="true">
                                </span>
                                <a href="<?= page_url(2) ?>">
                                    <?= sprintf(_('Buy me a %s coffee'), '<span aria-hidden="true">☕</span>') ?>
                                </a>
                            </li>
                            <li>
                                <span class="icon icon-custom icon-gaminghouse is-large" aria-hidden="true">
                                </span>
                                <a href="https://www.gaminghouse.community" rel="external noopener" target="_blank">
                                    GamingHouse
                                    <span class="sr-only"><?= _('(opens in a new window)') ?></span>
                                </a>
                                <span class="icon is-small" aria-hidden="true">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </span>
                            </li>
                            <li>
                                <span class="icon is-large" aria-hidden="true">
                                    <i class="fa-brands fa-creative-commons-by fa-3x"></i>
                                </span>
                                <a href="<?= page_url(1) ?>">
                                    <?= _('Credits') ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <p id="footer-realized-by">&copy; <?=date('Y')?> <?=_('A project realized by')?> <a href="https://github.com/eartahhj" rel="external noopener nofollow" target="_blank">eartahhj</a> - <span>{{ sprintf(_('Version: %s'), env('APP_VERSION')) }}</p>
            </div>
            <nav id="footer-bottom">
                <ul>
                    <li>
                        <a href="{{ route('datarequests.create') }}">{{ _('Send a request') }}</a>
                    </li>
                    <li>
                        <a href="{{ env('APP_WEBSITE_ADMIN') }}" rel="external noopener"><?= _('Need a web developer? Hire me') ?></a>
                    </li>
                    <li>
                        <a href="mailto:{{ env('APP_EMAIL_ADMIN') }}"><?= _('Want to advertise here? Email me') ?></a>
                    </li>
                </ul>
            </nav>
        </footer>
    </body>
</html>




