<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use App\Models\Publisher;
use App\Models\GamePlatform;
use Illuminate\Http\Request;
use App\Models\GameDeveloper;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $searchTitle = $request->input('title');
        $platformId = $request->input('platform');
        $developerId = $request->input('developer');
        $publisherId = $request->input('publisher');
        $responseCode = 200;
        $platforms = null;
        $platform = null;

        $games = Game::join('games_platforms', 'games.platform_id', '=', 'games_platforms.id')
            ->select('games.*', 'games_platforms.name AS platform_name')
            ->when($searchTitle, function($query, $searchTitle) {
                $query->where('title', 'LIKE', "%$searchTitle%");
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
        ->paginate(8);

        if (!$games->isEmpty()) {
            $platforms = GamePlatform::all();
        
            if ($platformId !== false) {
                $platform = $platforms->where('id', $platformId)->first();
            }
        } else {
            $responseCode = 404;
        }

        self::$templateStylesheets[] = '/css/games.css';

        return response()->view(
            'games.index',
            [
                'games' => $games,
                'platforms' => $platforms,
                'platform' => $platform,
                'searchTitle' => $searchTitle,
                'platformId' => $platformId,
                'templateStylesheets' => static::$templateStylesheets,
                'templateJavascripts' => static::$templateJavascripts
            ],
            $responseCode
        );
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('games.create', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function store(Request $request, Game $game)
    {
        // Rule::unique('reviews', 'text')
        $formFields = $request->validate([
            'title' => 'required',
            'description' => '',
            'platform_id' => 'required',
            'image' => '',
        ]);

        if ($newGame = Game::create($formFields)) {
            if ($request->hasFile('image')) {
                $fileFolder = 'images/games';
                $fileName = 'game-' . $newGame->id . '-image.png';
                $filePath = $request->file('image')->storeAs($fileFolder, $fileName, 'public');

                if (!$newGame->update(['image' => $fileFolder . '/' . $fileName])) {
                    return redirect(route('games.create'))->with('error', _('Error uploading image'));
                }
            }

            return redirect(route('games.edit', $newGame))->with('confirm', _('Game created'));
        } else {
            return redirect(route('games.create'))->with('error', _('Error creating game'));
        }

    }

    public function show(Game $game)
    {
        $image = '';
        $orderBy = Review::getOrderBy();

        self::$templateStylesheets[] = '/css/games.css';

        if ($game->developer_id) {
            $developer = GameDeveloper::find($game->developer_id);
        }

        if ($game->publisher_id) {
            $publisher = Publisher::find($game->publisher_id);
        }

        if (!empty($game->image)) {
            $image = \Image::make(\Storage::disk('public')->get($game->image));
        }

        $reviews = Review::where('game_id', $game->id)->orderBy($orderBy['column'], $orderBy['order'])->get();

        return view('games.show', compact('game', 'image', 'reviews', 'developer', 'publisher') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
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

        if (!empty($game->image)) {
            $image = \Image::make(\Storage::disk('public')->get($game->image));
        }

        return view('games.edit', compact('game', 'image') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function update(Request $request, Game $game)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'description' => '',
            'platform_id' => 'required',
            'image' => ''
        ]);

        if ($game->update($formFields)) {
            return redirect(route('games.edit', $game))->with('confirm', _('Game updated'));
        } else {
            return redirect(route('games.edit', $game))->with('error', _('Error updating the game'));
        }

    }

    public function destroy(Game $game)
    {
        if ($game->delete()) {
            return redirect(route('games.index'))->with('confirm', _('Game deleted'));
        } else {
            return redirect(route('games.edit', $game))->with('error', _('Error deleting game'));
        }
    }

    // public function showGamesByPlatform($platformId)
    // {
    //     return view('games.index', [
    //         'games' => \App\Models\Game::join('games_platforms', 'games.platform_id', '=', 'games_platforms.id')
    //             ->select('games.*', 'games_platforms.name AS platform_name')
    //             ->where('games_platforms.id', $platformId)
    //             ->paginate(8),
    //         'platform' => \App\Models\GamePlatform::findOrFail($platformId)
    //     ]);
    // }
}
