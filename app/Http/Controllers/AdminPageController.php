<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Page::all();

        $pageTitle = _('Manage pages');

        self::$templateStylesheets[] = '/css/panel.css';
        
        return response()->view('admin/pages/index', [
            'pages' => $pages,
            'pageTitle' => $pageTitle,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }
}
