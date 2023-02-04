<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        
        return response()->view('admin/pages/index', compact('pages'));
    }
}
