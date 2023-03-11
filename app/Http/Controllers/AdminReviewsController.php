<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::paginate(20);

        $pageTitle = _('Manage reviews');

        self::$templateStylesheets[] = '/css/panel.css';
        
        return response()->view('admin/reviews/index', [
            'reviews' => $reviews,
            'pageTitle' => $pageTitle,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }
}
