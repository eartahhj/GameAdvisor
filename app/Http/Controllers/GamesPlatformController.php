<?php

namespace App\Http\Controllers;

use App\Models\GamePlatform;
use Illuminate\Http\Request;

class GamesPlatformController extends Controller
{
    public function index(Request $request)
    {
        $platforms = GamePlatform::all();
        $platform = null;
        $responseCode = 200;

        if ($platforms->isEmpty()) {
            $responseCode = 404;
        }

        self::$templateStylesheets[] = '/css/platforms.css';

        return response()->view(
            'platforms.index',
            [
                'platforms' => $platforms,
                'templateStylesheets' => static::$templateStylesheets,
                'templateJavascripts' => static::$templateJavascripts
            ],
            $responseCode
        );
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('platforms.create', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($newPlatform = GamePlatform::create($formFields)) {
            return redirect(route('platforms.edit', $newPlatform))->with('confirm', _('Platform created'));
        } else {
            return redirect(route('platforms.create'))->with('error', _('Error creating platform'));
        }

    }

    public function show(GamePlatform $platform)
    {
        self::$templateStylesheets[] = '/css/platforms.css';
        
        return view('platforms.show', compact('platform') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(GamePlatform $platform)
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('platforms.edit', compact('platform') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function update(Request $request, GamePlatform $platform)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($platform->update($formFields)) {
            return redirect(route('platforms.edit', $platform))->with('confirm', _('Platform updated'));
        } else {
            return redirect(route('platforms.edit', $platform))->with('error', _('Error updating the platform'));
        }

    }

    public function destroy(GamePlatform $platform)
    {
        if ($platform->delete()) {
            return redirect(route('platforms.index'))->with('confirm', _('Platform deleted'));
        } else {
            return redirect(route('platforms.edit', $platform))->with('error', _('Error deleting platform'));
        }

    }
}
