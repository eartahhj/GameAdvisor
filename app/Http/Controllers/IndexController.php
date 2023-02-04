<?php

namespace App\Http\Controllers;

use App\Models\Index;
use App\Models\Review;
use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        self::$templateStylesheets[] = '/css/index.css';
        self::$templateStylesheets[] = '/css/reviews.css';
        self::$templateStylesheets[] = '/css/games.css';
        
        return view('index', [
            'latestReviews' => Review::join('games', 'reviews.game_id', '=', 'games.id')
            ->select('reviews.*', 'games.title AS game_title')
            ->latest()->get()->take(5),

            'games' => Game::join('games_platforms', 'games.platform_id', '=', 'games_platforms.id')
            ->select('games.*', 'games_platforms.name AS platform_name')
            ->paginate(10),

            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function show(Index $index)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function edit(Index $index)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Index $index)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function destroy(Index $index)
    {
        //
    }
}
