<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Review;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewCreatedNotificationToAdmin;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $orderBy = Review::getOrderBy();
        $orderByOptions = Review::getOrderByOptions();
        $platformId = $request->input('platform');
        $platform = null;
        $platforms = Platform::all();
        $rating = $request->input('rating');
        $ratings = Review::getRatings();

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/reviews.css';

        $reviews = Review::join('games', 'reviews.game_id', '=', 'games.id')
        ->select('reviews.*', 'games.title_' . getLanguage() . ' AS game_title')
        ->when($platformId, function($query, $platformId) {
            $query->where('games.platform_id', '=', $platformId);
        })
        ->when($rating, function($query, $rating) {
            $query->where('reviews.rating', '=', $rating);
        })
        ->where('reviews.approved', 1)
        ->orderBy($orderBy['column'], $orderBy['order'])
        ->paginate(12);

        if ($platformId !== false) {
            $platform = $platforms->where('id', $platformId)->first();
        }

        if ($reviews->isEmpty()) {
            $pageTitle = _('No reviews to show at the moment.');
        } else {
            if (!empty($rating) and !empty($platform)) {
                $pageTitle = sprintf(_('All reviews for: %s, with rating of %s'), $platform->name, $rating . ' ' . ngettext('star', 'stars', $rating));
            } elseif (!empty($rating)) {
                $pageTitle = sprintf(_('All reviews with rating: %s'), $rating);
            } elseif (!empty($platform))  {
                $pageTitle = sprintf(_('All reviews for: %s'), $platform->name);
            } else {
                $pageTitle = _('All reviews');
            }
        }        
        
        if ($platformId !== false) {
            $platform = $platforms->where('id', $platformId)->first();
        }
   
        return view('reviews.index', [
            'reviews' => $reviews,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => $pageTitle,
            'orderByOptions' => $orderByOptions,
            'platforms' => $platforms,
            'platformId' => $platformId,
            'ratings' => $ratings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Game $game)
    {
        // TODO test 2023-02-11
        $authorName = auth()->user()->name ?? old('author_name') ?? '';
        $authorEmail = auth()->user()->email ?? old('author_email') ?? '';

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/rating-radiolist.css';
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';

        $gameLink = '<a href="' . route('games.show', $game) . '">' . htmlspecialchars($game->title) . '</a>';

        return view('reviews.create', [
            'game' => $game,
            'authorName' => $authorName,
            'authorEmail' => $authorEmail,
            'gameLink' => $gameLink,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('New review'),
            'supportedImageFormats' => Review::returnImageSupportedFormatsString()
        ]);
    }

    public function store(Request $request, Game $game)
    {
        $fieldsToValidate = [
            'title' => 'required',
            'text' => 'required',
            'rating' => 'required',
            'hours_played' => 'nullable|numeric'
        ];

        $imageError = null;

        if (!empty(auth()->user()) and auth()->user()->email_verified_at) {
            $fieldsToValidate['image'] = Review::returnImageValidationString();
        }

        if (empty(auth()->user())) {
            $fieldsToValidate['author_name'] = '';
            $fieldsToValidate['author_email'] = 'nullable|email';
        } else {
            if (empty($request->is_anonymous)) {
                $fieldsToValidate['author_name'] = '';
                $fieldsToValidate['author_email'] = 'email';
            }
        }

        $formFields = $request->validate($fieldsToValidate);

        if (!empty(auth()->user()->id)) {
            $formFields['user_id'] = auth()->user()->id;

            if (auth()->user()->name) {
                $formFields['author_name'] = auth()->user()->name;
            }

            if (auth()->user()->email) {
                $formFields['author_email'] = auth()->user()->email;
            }
        }

        $formFields['game_id'] = $game->id;

        if ($newReview = Review::create($formFields)) {
            // dd ($newReview);
            if ($request->hasFile('image') and !empty(auth()->user()) and auth()->user()->email_verified_at) {
                if ($image = $newReview->uploadImage()) {
                    $newReview->image = $image;
                    $newReview->save();
                } else {
                    $imageError = _('Your review has been created but there was an error uploading the image.');
                }
            }

            $emailToAdmin = new ReviewCreatedNotificationToAdmin($newReview);
            Mail::to(env('APP_EMAIL_ADMIN'))->send($emailToAdmin);

            if ($imageError) {
                return redirect(route('reviews.index'))->with('warning', $imageError);
            }

            if (!empty(auth()->user()->id) and empty($request->is_anonymous)) {
                return redirect(route('user.myReviews'))->with('confirm', _('Thank you for submitting your review! Please note that it must be approved before being published!'));
            } else {
                return redirect(route('reviews.index'))->with('confirm', _('Thank you for submitting your review! Please note that it must be approved before being published!'));
            }
        } else {
            return back()->with('error', _('Error creating review'));
        }
    }

    public function show(Review $review)
    {
        if (!$review->approved) {
            if (auth()->user() and auth()->user()->id) {
                if ($review->user_id != auth()->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        $game = Game::findOrFail($review->game_id);
        $user = null;

        if ($review->user_id) {
            $user = User::find($review->user_id);

            if ($user->private_profile) {
                $user = null;
            }
        }

        $pageTitle = $review->title;

        self::$templateStylesheets[] = '/css/reviews.css';

        $image = null;

        if (!empty($review->image)) {
            $image = \Image::make(\Storage::disk('public')->get($review->image));
        }
        
        return view('reviews.show', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => $pageTitle,
            'game' => $game,
            'review' => $review,
            'user' => $user,
            'image' => $image,
            'pageHasAds' => true
        ]);
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
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';

        $image = null;
        
        if (!empty($review->image)) {
            $image = \Image::make(\Storage::disk('public')->get($review->image));
        }
        
        return view('reviews.edit', [
            'review' => $review,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Edit review'),
            'image' => $image,
            'supportedImageFormats' => Review::returnImageSupportedFormatsString()
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'text' => 'required',
            'author_email' => 'email',
            'image' => Review::returnImageValidationString(),
            'hours_played' => 'numeric'
        ]);

        if ($request->hasFile('image')) {
            if ($review->image) {
                Storage::delete($review->image);
            }

            $image = $review->uploadImage();

            $formFields['image'] = $image;
        }

        if ($review->update($formFields)) {
            return back()->with('confirm', _('Review updated'));
        } else {
            return back()->with('error', _('Error updating the review'));
        }
    }

    public function destroy(Review $review)
    {
        if (!empty(auth()->user()->id) and $review->user_id != auth()->user()->id) {
            abort(403, _('Unauthorized action'));
        }

        $imageToDelete = null;
        
        if ($platform->image) {
            $imageToDelete = $platform->game;
        }

        if ($review->delete()) {
            
            if ($imageToDelete) {
                Storage::delete($imageToDelete);
            }

            return redirect(route('reviews.index'))->with('confirm', _('Review deleted'));
        } else {
            return redirect(route('reviews.edit', $review))->with('error', _('Error deleting review'));
        }
    }

    public function approve(int $id)
    {
        if (!auth()->user()->is_superadmin) {
            abort(401);
        }

        if (request()->input('approve') == 1) {
            $approved = true;
        } elseif (request()->input('unapprove') == 1) {
            $approved = false;
        } else {
            return back()->with('error', _('An error occured during the approve/revoke operation'));
        }

        $review = Review::findOrFail($id);
        $review->approved = $approved;

        if ($review->save() === false) {
            return back()->with('errors', $review->errors());
        }

        if ($approved) {
            $message = sprintf(_('Review #%s has been approved'), $review->id);
        } else {
            $message = sprintf(_('Review #%s has been unapproved'), $review->id);
        }

        return back()->with('success', $message);
    }

    public function showReviewsByGame($gameId)
    {
        $responseCode = 200;
        $game = null;
        $platformId = request()->input('platform');
        $orderBy = Review::getOrderBy();
        $orderByOptions = Review::getOrderByOptions();

        self::$templateStylesheets[] = '/css/reviews.css';

        $reviews = Review::join('games', 'reviews.game_id', '=', 'games.id')
        ->select('reviews.*', 'games.title_' . getLanguage() . ' AS game_title')
        ->when($platformId, function($query, $platformId) {
            $query->where('games.platform_id', '=', $platformId);
        })
        ->where('reviews.game_id', $gameId)
        ->orderBy($orderBy['column'], $orderBy['order'])
        ->get();

        $game = Game::findOrFail($gameId);

        if ($reviews->isEmpty()) {
            $responseCode = 404;
            $pageTitle = _('No reviews to show at the moment.');
        } else {
            $pageTitle = sprintf(_('All reviews for: %s'), $game->title);
        }

        return response()->view('reviews.index', [
            'reviews' => $reviews,
            'game' => $game,
            'pageTitle' => $pageTitle,
            'orderByOptions' => $orderByOptions,
            'pageHasAds' => true
        ], $responseCode);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chooseGame(Platform $platform = null)
    {
        // if ($platform) {
        //     $games = Game::join('platforms', 'games.platform_id', '=', 'platforms.id')
        //     ->select('games.*', 'platforms.name_' . getLanguage() . ' AS platform_name')
        //     ->where('games.platform_id', $platform->id)
        //     ->paginate(8);
        // } else {
        //     $games = Game::join('platforms', 'games.platform_id', '=', 'platforms.id')
        //     ->select('games.*', 'platforms.name_' . getLanguage() . ' AS platform_name')
        //     ->paginate(8);
        // }

        self::$templateStylesheets[] = '/css/games.css';
        
        $games = Game::join('platforms', 'games.platform_id', '=', 'platforms.id')
            ->select('games.*', 'platforms.name_' . getLanguage() . ' AS platform_name')
            ->when($platform, function($query, $platform) {
                $query->where('games.platform_id', $platform->id);
            })
            ->paginate(8);

        return view('reviews.choose-game', [
            'games' => $games,
            'platform' => $platform,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Choose a game to review')
        ]);
    }
}
