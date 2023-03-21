<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeveloperController extends Controller
{
    public function index(Request $request)
    {
        $developerId = $request->input('developer');
        $searchName = 'name_' . getLanguage();
        $searchValue = $request->input($searchName);
        $responseCode = 200;
        $developer = null;
        $orderBy = Developer::getOrderBy();
        $orderByOptions = Developer::getOrderByOptions();

        $developers = Developer::select()
        ->when($searchValue, function ($query, $searchValue) use ($searchName) {
            $query->where($searchName, 'LIKE', "%$searchValue%");
        })
        ->orderBy($orderBy['column'], $orderBy['order'])
        ->paginate(12);
        
        if (!$developers->isEmpty()) {
            if ($developerId !== false) {
                $developer = $developers->where('id', $developerId)->first();
            }
        } else {
            $responseCode = 404;
        }

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/developers.css';

        if ($developers->isEmpty()) {
            $responseCode = 404;
            $pageTitle = _('No developers to show at the moment.');
        } else {
            if (empty($searchValue)) {
                $pageTitle = _('All developers');
            } else {
                $pageTitle = sprintf(_('All developers for: %s'), $searchValue);
            }
        }

        $pageHasAds = true;
        if ($developers->isEmpty()) {
            $pageHasAds = false;
        }

        return response()->view(
            'developers.index',
            [
                'developers' => $developers,
                'searchName' => $searchName,
                'searchValue' => $searchValue,
                'developer' => $developer,
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

        return view('developers.create', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('New developer'),
            'supportedImageFormats' => Developer::returnImageSupportedFormatsString()
        ]);
    }

    public function store(Request $request, Developer $developer)
    {
        $formFields = $request->validate([
            'name_en' => 'required',
            'name_it' => '',
            'description_en' => '',
            'description_it' => '',
            'logo' => Developer::returnImageValidationString(),
            'link_en' => 'nullable|url',
            'link_it' => 'nullable|url',
        ]);

        $formFields['approved'] = true;

        if ($newDeveloper = Developer::create($formFields)) {
            if ($request->hasFile('logo') and $image = $newDeveloper->uploadImage('logo')) {
                $newDeveloper->logo = $image;
                $newDeveloper->save();
            }

            return redirect(route('developers.edit', $newDeveloper))->with('confirm', _('Developer created'));
        } else {
            return redirect(route('developers.create'))->with('error', _('Error creating developer'));
        }

    }

    public function show(Developer $developer)
    {
        self::$templateStylesheets[] = '/css/developers.css';

        $pageTitle = sprintf(_('Developer: %s'), $developer->name);

        $numberOfGames = Game::where('developer_id', $developer->id)->count('developer_id') or 0;

        $image = null;
        
        if (!empty($developer->logo)) {
            $logo = \Image::make(\Storage::disk('public')->get($developer->logo));
        }

        $pageHasAds = true;
        if ($developer->description == '') {
            $pageHasAds = false;
        }

        return view('developers.show', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => $pageTitle,
            'developer' => $developer,
            'numberOfGames' => $numberOfGames,
            'logo' => $logo,
            'pageHasAds' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Developer $developer)
    {
        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';

        $image = null;
        
        if (!empty($developer->logo)) {
            $logo = \Image::make(\Storage::disk('public')->get($developer->logo));
        }
        
        return view('developers.edit', compact('developer') + [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Edit developer'),
            'developer' => $developer,
            'image' => $logo,
            'supportedImageFormats' => Developer::returnImageSupportedFormatsString()
        ]);
    }

    public function update(Request $request, Developer $developer)
    {
        $formFields = $request->validate([
            'name_en' => 'required',
            'name_it' => '',
            'description_en' => '',
            'description_it' => '',
            'logo' => Developer::returnImageValidationString(),
            'link_en' => 'nullable|url',
            'link_it' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            if ($developer->logo) {
                Storage::delete($developer->logo);
            }

            $image = $developer->uploadImage('logo');
            $formFields['logo'] = $image;
        }

        if ($developer->update($formFields)) {
            return redirect(route('developers.edit', $developer))->with('confirm', _('Developer updated'));
        } else {
            return redirect(route('developers.edit', $developer))->with('error', _('Error updating the developer'));
        }

    }

    public function destroy(Developer $developer)
    {
        $imageToDelete = null;

        if ($developer->logo) {
            $imageToDelete = $developer->logo;
        }

        if ($developer->delete()) {
            if ($imageToDelete) {
                Storage::delete($imageToDelete);
            }
            
            return redirect(route('developers.index'))->with('confirm', _('Developer deleted'));
        } else {
            return redirect(route('developers.edit', $developer))->with('error', _('Error deleting developer'));
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

        $developer = Developer::findOrFail($id);
        $developer->approved = $approved;

        if ($developer->save() === false) {
            return back()->with('errors', $developer->errors());
        }

        if ($approved) {
            $message = sprintf(_('Developer #%s has been approved'), $developer->id);
        } else {
            $message = sprintf(_('Developer #%s has been unapproved'), $developer->id);
        }

        return back()->with('success', $message);
    }
}
