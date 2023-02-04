<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Game;
use App\Models\GamePlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function index()
    {
        $orderBy = Review::getOrderBy();

        self::$templateStylesheets[] = '/css/reviews.css';

        return view('reviews.index', [
            'reviews' => Review::join('games', 'reviews.game_id', '=', 'games.id')
            ->select('reviews.*', 'games.title AS game_title')
            ->orderBy($orderBy['column'], $orderBy['order'])
            ->paginate(5),
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Game $game)
    {
        $authorName = auth()->user()->name ?? old('author_name') ?? '';
        $authorEmail = auth()->user()->email ?? old('author_email') ?? '';

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/rating-radiolist.css';

        $gameLink = '<a href="' . route('games.show', $game) . '">' . htmlspecialchars($game->title) . '</a>';

        return view('reviews.create', compact('game', 'authorName', 'authorEmail', 'gameLink') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function store(Request $request, $game)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'text' => 'required',
            'rating' => 'required',
        ]);

        if (empty($request->is_anonymous)) {
            $formFields += $request->validate([
                'author_name' => '',
                'author_email' => 'email'
            ]);

            if (!empty(auth()->user()->id)) {
                $formFields['user_id'] = auth()->user()->id;

                if (auth()->user()->name) {
                    $formFields['author_name'] = auth()->user()->name;
                }

                if (auth()->user()->email) {
                    $formFields['author_email'] = auth()->user()->email;
                }
            }
        }

        $formFields['game_id'] = $game;

        if ($newReview = Review::create($formFields)) {
            if (!empty(auth()->user()->id)) {
                return redirect(route('reviews.edit', ['review' => $newReview]))->with('confirm', _('Review created'));
            } else {
                return redirect(route('reviews.index'))->with('confirm', _('Review created'));
            }
        } else {
            return back()->with('error', _('Error creating review'));
        }
    }

    public function show(Review $review)
    {
        // $review = Review::findOrFail($id);
        
        return view('reviews.show', compact('review') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        self::$templateStylesheets[] = '/css/forms.css';
        
        return view('reviews.edit', ['review' => $review, 'templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function update(Request $request, Review $review)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'text' => 'required',
            'author_email' => 'email'
        ]);

        if ($review->update($formFields)) {
            return redirect(route('reviews.edit', $review))->with('confirm', _('Review updated'));
        } else {
            return redirect(route('reviews.edit', $review))->with('error', _('Error updating the review'));
        }
    }

    public function destroy(Review $review)
    {
        if (!empty(auth()->user()->id) and $review->user_id != auth()->user()->id) {
            abort(403, _('Unauthorized action'));
        }

        if ($review->delete()) {
            return redirect(route('reviews.index'))->with('confirm', _('Review deleted'));
        } else {
            return redirect(route('reviews.edit', $review))->with('error', _('Error deleting review'));
        }
    }

    public function showReviewsByGame($gameId)
    {
        $responseCode = 200;
        $game = null;

        $reviews = \App\Models\Review::join('games', 'reviews.game_id', '=', 'games.id')
        ->select('reviews.*', 'games.title AS game_title')
        ->where('reviews.game_id', $gameId)
        ->get();

        $game = \App\Models\Game::findOrFail($gameId);

        if ($reviews->isEmpty()) {
            $responseCode = 404;
        }

        return response()->view('reviews.index', [
            'reviews' => $reviews,
            'game' => $game
        ], $responseCode);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chooseGame(GamePlatform $platform = null)
    {
        // if ($platform) {
        //     $games = Game::join('games_platforms', 'games.platform_id', '=', 'games_platforms.id')
        //     ->select('games.*', 'games_platforms.name AS platform_name')
        //     ->where('games.platform_id', $platform->id)
        //     ->paginate(8);
        // } else {
        //     $games = Game::join('games_platforms', 'games.platform_id', '=', 'games_platforms.id')
        //     ->select('games.*', 'games_platforms.name AS platform_name')
        //     ->paginate(8);
        // }

        self::$templateStylesheets[] = '/css/games.css';
        
        $games = Game::join('games_platforms', 'games.platform_id', '=', 'games_platforms.id')
            ->select('games.*', 'games_platforms.name AS platform_name')
            ->when($platform, function($query, $platform) {
                $query->where('games.platform_id', $platform->id);
            })
            ->paginate(8);

        return view('reviews.choose-game', [
            'games' => $games,
            'platform' => $platform,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }
}
