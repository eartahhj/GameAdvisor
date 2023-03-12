<?php

namespace App\Providers;

use MatomoTracker;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        # 2022-08-07 added because of a problem with MariaDB 10.3.3 + InnoDB + utf8mb4_unicode_ci + Laravel's migration,
        # where MySQL was returning an error because the VARCHAR(255) exceeds the length limit
        Schema::defaultStringLength(191);

        Paginator::defaultView('pagination.pagination-bulma');
        Paginator::defaultSimpleView('pagination.pagination-simple-bulma');

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        
        // $this->twig = new Twig();

        $languages = config('app')['languages'];

        $preferredLanguage = env('APP_LANGUAGE_DEFAULT');

        if ($chosenLanguage = request()->query('lang')) {
            if (isset($languages[$chosenLanguage])) {
                session(['preferredLanguage' => $chosenLanguage]);
            }
        }

        if (session('preferredLanguage')) {
            App::setLocale(session('preferredLanguage'));
        } else {
            $path = request()->path();
            if (mb_strlen($path >= 2)) {
                $chosenLanguage = substr($path, 0, 2);
                if (isset($languages[$chosenLanguage])) {
                    App::setLocale($chosenLanguage);
                }
            } else {
                App::setLocale(env('APP_LANGUAGE_DEFAULT'));
            }
        }

        loadGettext(App::currentLocale());

        $animationsCookie = request()->cookie('animations');
        if (empty($animationsCookie) or $animationsCookie == 'on') {
            $animationsEnabled = true;
        } else {
            $animationsEnabled = false;
        }

        $showCookiePolicyBanner = true;
        $cookiesConsent = request()->cookie('cookiesConsent');
        $adsEnabled = false;

        if (!empty($cookiesConsent)) {
            $showCookiePolicyBanner = false;

            if (strpos($cookiesConsent, 'ads')) {
                $adsEnabled = true;
            }
        }

        $matomoSiteId = env('MATOMO_SITEID');
        $matomoUrl = env('MATOMO_HOST');
        $matomoToken = env('MATOMO_TOKEN');
        $matomoPageTitle = '';

        $matomoTracker = new MatomoTracker($matomoSiteId, $matomoUrl);
        $matomoTracker->setTokenAuth($matomoToken);

        View::share('locale', App::currentLocale());
        View::share('animationsEnabled', $animationsEnabled);
        View::share('languages', $languages);
        View::share('matomoTracker', $matomoTracker);
        View::share('showCookiePolicyBanner', $showCookiePolicyBanner);
        View::share('adsEnabled', $adsEnabled);
    }
}
