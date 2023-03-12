<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use App\Models\Platform;
use App\Models\Developer;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $searchName = 'title_' . getLanguage();
        $searchValue = $request->input($searchName);
        $platformId = $request->input('platform');
        $developerId = $request->input('developer');
        $publisherId = $request->input('publisher');
        $responseCode = 200;
        $platforms = Platform::all();
        $platform = null;
        $orderBy = Game::getOrderBy();
        $orderByOptions = Game::getOrderByOptions();

        $games = Game::join('platforms', 'games.platform_id', '=', 'platforms.id')
            ->select('games.*', 'platforms.name_' . getLanguage() . ' AS platform_name')
            ->when($searchValue, function ($query, $searchValue) use ($searchName) {
                $query->where($searchName, 'LIKE', "%$searchValue%");
            })
            ->when($platformId, function($query, $platformId) {
                $query->where('games.platform_id', '=', $platformId);
            })
            ->when($developerId, function($query, $developerId) {
                $query->where('games.developer_id', '=', $developerId);
            })
            ->when($publisherId, function($query, $publisherId) {
                $query->where('games.publisher_id', '=', $publisherId);
            })
            ->when(!auth()->user()->is_superadmin, function($query) {
                $query->where('games.approved', 1);
            })
        ->orderBy($orderBy['column'], $orderBy['order'])
        ->paginate(12);
        
        if ($platformId !== false) {
            $platform = $platforms->where('id', $platformId)->first();
        }

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/games.css';

        if ($games->isEmpty()) {
            $pageTitle = _('No games to show at the moment.');
            $responseCode = 404;
        } else {
            if (!empty($searchValue) and !empty($platform)) {
                $pageTitle = sprintf(_('All games for: %s, %s'), $searchValue, $platform->name);
            } elseif (!empty($searchValue)) {
                $pageTitle = sprintf(_('All games for: %s'), $searchValue);
            } elseif (!empty($platform))  {
                $pageTitle = sprintf(_('All games for: %s'), $platform->name);
            } else {
                $pageTitle = _('All games');
            }
        }

        return response()->view(
            'games.index',
            [
                'games' => $games,
                'platforms' => $platforms,
                'platform' => $platform,
                'searchName' => $searchName,
                'searchValue' => $searchValue,
                'platformId' => $platformId,
                'templateStylesheets' => static::$templateStylesheets,
                'templateJavascripts' => static::$templateJavascripts,
                'pageTitle' => $pageTitle,
                'orderByOptions' => $orderByOptions
            ],
            $responseCode
        );
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';
        self::$templateJavascripts[] = '/js/tinymce/tinymce.min.js';
        self::$templateJavascripts[] = '/js/tinymce-init.js';

        $platforms = Platform::all();

        return view('games.create', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Insert a new game'),
            'platforms' => $platforms,
            'supportedImageFormats' => Game::returnImageSupportedFormatsString()
        ]);
    }

    public function store(Request $request, Game $game)
    {
        // Rule::unique('reviews', 'text')
        $formFields = $request->validate([
            'title_en' => 'required',
            'title_it' => 'required',
            'description_it' => '',
            'description_en' => '',
            'platform_id' => 'required',
            'image' => Game::returnImageValidationString()
        ]);

        if ($request->hasFile('image')) {
            $image = $game->uploadImage();
            $formFields['image'] = $image;
        }

        $formFields['approved'] = true;

        if ($newGame = Game::create($formFields)) {
            return redirect(route('games.edit', $newGame))->with('confirm', _('Game created'));
        } else {
            return redirect(route('games.create'))->with('error', _('Error creating game'));
        }
    }

    public function show(Game $game)
    {
        if (!$game->approved) {
            abort(401);
        }

        $orderBy = Review::getOrderBy();

        self::$templateStylesheets[] = '/css/games.css';
        self::$templateStylesheets[] = '/css/reviews.css';

        if ($game->developer_id) {
            $developer = Developer::find($game->developer_id);
        }

        if ($game->publisher_id) {
            $publisher = Publisher::find($game->publisher_id);
        }

        $image = null;

        if (!empty($game->image)) {
            $image = \Image::make(\Storage::disk('public')->get($game->image));
        }

        $reviews = Review::where([
            'game_id' => $game->id,
            'approved' => 1
        ])->orderBy($orderBy['column'], $orderBy['order'])->get();

        $rating = Review::where([
            'game_id' => $game->id,
            'approved' => 1
        ])->avg('rating') or 0;

        $numberOfVotes = 0;
        if ($rating) {
            $numberOfVotes = $reviews->count();
        }

        $pageTitle = $game->title;

        return view('games.show', [
            'game' => $game,
            'image' => $image,
            'reviews' => $reviews,
            'developer' => $developer,
            'publisher' => $publisher,
            'rating' => $rating,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => $pageTitle,
            'numberOfVotes' => $numberOfVotes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $image = '';

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';
        self::$templateJavascripts[] = '/js/tinymce/tinymce.min.js';
        self::$templateJavascripts[] = '/js/tinymce-init.js';

        $platforms = Platform::all();

        $image = null;

        if (!empty($game->image)) {
            $image = \Image::make(\Storage::disk('public')->get($game->image));
        }

        return view('games.edit', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Edit game'),
            'platforms' => $platforms,
            'game' => $game,
            'image' => $image,
            'supportedImageFormats' => Game::returnImageSupportedFormatsString()
        ]);
    }

    public function update(Request $request, Game $game)
    {
        $formFields = $request->validate([
            'title_en' => 'required',
            'title_it' => 'required',
            'description_it' => '',
            'description_en' => '',
            'platform_id' => 'required',
            'image' => Game::returnImageValidationString()
        ]);

        if ($request->hasFile('image')) {
            if ($game->image) {
                Storage::delete($game->image);
            }

            $image = $game->uploadImage();

            $formFields['image'] = $image;
        }

        if ($game->update($formFields)) {
            return back()->with('confirm', _('Game updated'));
        } else {
            return back()->with('error', _('Error updating the game'));
        }

    }

    public function destroy(Game $game)
    {
        $imageToDelete = null;
        
        if ($game->image) {
            $imageToDelete = $review->game;
        }
        
        if ($game->delete()) {
            if ($imageToDelete) {
                Storage::delete($imageToDelete);
            }
            return redirect(route('games.index'))->with('confirm', _('Game deleted'));
        } else {
            return redirect(route('games.edit', $game))->with('error', _('Error deleting game'));
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

        $game = Game::findOrFail($id);
        $game->approved = $approved;

        if ($game->save() === false) {
            return back()->with('errors', $game->errors());
        }

        if ($approved) {
            $message = sprintf(_('Game #%s has been approved'), $game->id);
        } else {
            $message = sprintf(_('Game #%s has been unapproved'), $game->id);
        }

        return back()->with('success', $message);
    }
}
