<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatformController extends Controller
{
    public function index(Request $request)
    {
        $responseCode = 200;
        $searchName = 'name_' . getLanguage();
        $searchValue = $request->input($searchName);
        $orderBy = Platform::getOrderBy();
        $orderByOptions = Platform::getOrderByOptions();

        $platforms = Platform::select()
        ->when($searchValue, function ($query, $searchValue) use ($searchName) {
            $query->where($searchName, 'LIKE', "%$searchValue%");
        })
        ->orderBy($orderBy['column'], $orderBy['order'])
        ->paginate(12);

        $platform = null;

        if ($platforms->isEmpty()) {
            $responseCode = 404;
            $pageTitle = _('No platforms to show at the moment.');
        } else {
            if (empty($searchValue)) {
                $pageTitle = _('All platforms');
            } else {
                $pageTitle = sprintf(_('All platforms for: %s'), $searchValue);
            }
        }

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/platforms.css';

        $pageHasAds = true;
        if ($platforms->isEmpty()) {
            $pageHasAds = false;
        }

        return response()->view(
            'platforms.index',
            [
                'platforms' => $platforms,
                'searchName' => $searchName,
                'searchValue' => $searchValue,
                'templateStylesheets' => static::$templateStylesheets,
                'templateJavascripts' => static::$templateJavascripts,
                'pageTitle' => $pageTitle,
                'orderByOptions' => $orderByOptions,
                'pageHasAds' => $pageHasAds
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

        return view('platforms.create', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('New platform'),
            'supportedImageFormats' => Platform::returnImageSupportedFormatsString()
        ]);
    }

    public function store(Request $request, Platform $platform)
    {
        $formFields = $request->validate([
            'name_en' => 'required',
            'name_it' => '',
            'description_en' => '',
            'description_it' => '',
            'image' => Platform::returnImageValidationString(),
            'link_en' => 'nullable|url',
            'link_it' => 'nullable|url',
        ]);

        if ($newPlatform = Platform::create($formFields)) {
            if ($request->hasFile('image') and $image = $newPlatform->uploadImage()) {
                $newPlatform->image = $image;
                $newPlatform->save();
            }

            return redirect(route('platforms.edit', $newPlatform))->with('confirm', _('Platform created'));
        } else {
            return redirect(route('platforms.create'))->with('error', _('Error creating platform'));
        }
    }

    public function show(Platform $platform)
    {
        self::$templateStylesheets[] = '/css/platforms.css';

        $pageTitle = sprintf(_('Platform: %s'), $platform->name);

        $numberOfGames = Game::where('platform_id', $platform->id)->count('platform_id') or 0;

        $image = null;
        
        if (!empty($platform->image)) {
            $image = \Image::make(\Storage::disk('public')->get($platform->image));
        }

        $pageHasAds = true;
        if ($platform->description == '') {
            $pageHasAds = false;
        }

        return view('platforms.show', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => $pageTitle,
            'platform' => $platform,
            'numberOfGames' => $numberOfGames,
            'image' => $image,
            'pageHasAds' => $pageHasAds
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Platform $platform)
    {
        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';

        $image = null;

        if (!empty($platform->image)) {
            $image = \Image::make(\Storage::disk('public')->get($platform->image));
        }

        return view('platforms.edit', compact('platform') + [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Edit platform'),
            'image' => $image,
            'supportedImageFormats' => Platform::returnImageSupportedFormatsString()
        ]);
    }

    public function update(Request $request, Platform $platform)
    {
        $formFields = $request->validate([
            'name_en' => 'required',
            'name_it' => '',
            'description_en' => '',
            'description_it' => '',
            'image' => Platform::returnImageValidationString(),
            'link_en' => 'nullable|url',
            'link_it' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            if ($platform->image) {
                Storage::delete($platform->image);
            }

            $image = $platform->uploadImage();
            $formFields['image'] = $image;
        }

        if ($platform->update($formFields)) {
            return redirect(route('platforms.edit', $platform))->with('confirm', _('Platform updated'));
        } else {
            return redirect(route('platforms.edit', $platform))->with('error', _('Error updating the platform'));
        }
    }

    public function destroy(Platform $platform)
    {
        $imageToDelete = null;

        if ($platform->image) {
            $imageToDelete = $platform->game;
        }

        if ($platform->delete()) {
            if ($imageToDelete) {
                Storage::delete($imageToDelete);
            }
            
            return redirect(route('platforms.index'))->with('confirm', _('Platform deleted'));
        } else {
            return redirect(route('platforms.edit', $platform))->with('error', _('Error deleting platform'));
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

        $platform = Platform::findOrFail($id);
        $platform->approved = $approved;

        if ($platform->save() === false) {
            return back()->with('errors', $platform->errors());
        }

        if ($approved) {
            $message = sprintf(_('Platform #%s has been approved'), $platform->id);
        } else {
            $message = sprintf(_('Platform #%s has been unapproved'), $platform->id);
        }

        return back()->with('success', $message);
    }
}
