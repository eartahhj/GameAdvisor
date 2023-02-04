<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameDeveloper;
use Illuminate\Support\Facades\DB;

class GamesDeveloperController extends Controller
{
    public function index(Request $request)
    {
        $developerId = $request->input('developer');
        $searchName = $request->input('name');
        $responseCode = 200;
        $developer = null;

        $developers = DB::table('game_developers')
        ->when($searchName, function($query, $searchName) {
            $query->where('name', 'LIKE', "%$searchName%");
        })
        ->get();
        
        if (!$developers->isEmpty()) {
            if ($developerId !== false) {
                $developer = $developers->where('id', $developerId)->first();
            }
        } else {
            $responseCode = 404;
        }

        self::$templateStylesheets[] = '/css/developers.css';

        return response()->view(
            'developers.index',
            [
                'developers' => $developers,
                'searchName' => $searchName,
                'developer' => $developer,
                'templateStylesheets' => static::$templateStylesheets,
                'templateJavascripts' => static::$templateJavascripts
            ],
            $responseCode
        );
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('developers.create', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($newdeveloper = GameDeveloper::create($formFields)) {
            return redirect(route('developers.edit', $newdeveloper))->with('confirm', _('Developer created'));
        } else {
            return redirect(route('developers.create'))->with('error', _('Error creating developer'));
        }

    }

    public function show(GameDeveloper $developer)
    {
        self::$templateStylesheets[] = '/css/developers.css';

        return view('developers.show', compact('developer') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(GameDeveloper $developer)
    {
        self::$templateStylesheets[] = '/css/forms.css';
        
        return view('developers.edit', compact('developer') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function update(Request $request, GameDeveloper $developer)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($developer->update($formFields)) {
            return redirect(route('developers.edit', $developer))->with('confirm', _('Developer updated'));
        } else {
            return redirect(route('developers.edit', $developer))->with('error', _('Error updating the developer'));
        }

    }

    public function destroy(GameDeveloper $developer)
    {
        if ($developer->delete()) {
            return redirect(route('developers.index'))->with('confirm', _('Developer deleted'));
        } else {
            return redirect(route('developers.edit', $developer))->with('error', _('Error deleting developer'));
        }

    }
}
