<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static array $templateJavascripts = [];
    public static array $templateStylesheets = [];
    public static string $pageTitle = '';

    public function __construct()
    {        
        $this->middleware(function ($request, $next) {
            View::share('authUser', auth()->user());
            View::share('isLoggedIn', Auth::check());
            return $next($request);
        });
    }
}
