<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'orderByOptions' => $orderByOptions
            ],
            $responseCode
        );
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

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
            'logo' => Developer::returnImageValidationString()
        ]);

        if ($request->hasFile('logo')) {
            $image = $developer->uploadImage();
            $formFields['logo'] = $image;
        }

        if ($newDeveloper = Developer::create($formFields)) {
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
        
        if (!empty($developer->image)) {
            $image = \Image::make(\Storage::disk('public')->get($developer->image));
        }

        return view('developers.show', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => $pageTitle,
            'developer' => $developer,
            'numberOfGames' => $numberOfGames,
            'image' => $image
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

        $image = null;
        
        if (!empty($developer->image)) {
            $image = \Image::make(\Storage::disk('public')->get($developer->image));
        }
        
        return view('developers.edit', compact('developer') + [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Edit developer'),
            'developer' => $developer,
            'image' => $image,
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
            'logo' => Developer::returnImageValidationString()
        ]);

        if ($request->hasFile('logo')) {
            if ($developer->logo) {
                Storage::delete($developer->logo);
            }

            $image = $developer->uploadImage();
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
}
