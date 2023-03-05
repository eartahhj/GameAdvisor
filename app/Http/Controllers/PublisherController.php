<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publisherId = $request->input('publisher');
        $searchName = 'name_' . getLanguage();
        $searchValue = $request->input($searchName);
        $responseCode = 200;
        $publisher = null;
        $orderBy = Publisher::getOrderBy();
        $orderByOptions = Publisher::getOrderByOptions();

        $publishers = Publisher::select()
        ->when($searchValue, function ($query, $searchValue) use ($searchName) {
            $query->where($searchName, 'LIKE', "%$searchValue%");
        })
        ->orderBy($orderBy['column'], $orderBy['order'])
        ->paginate(12);

        if (!$publishers->isEmpty()) {
            if ($publisherId !== false) {
                $publisher = $publishers->where('id', $publisherId)->first();
            }
        } else {
            $responseCode = 404;
        }

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/publishers.css';

        if ($publishers->isEmpty()) {
            $pageTitle = _('No publishers to show at the moment.');
        } else {
            if (empty($searchValue)) {
                $pageTitle = _('All publishers');
            } else {
                $pageTitle = sprintf(_('All publishers for: %s'), $searchValue);
            }
        }

        return response()->view(
            'publishers.index',
            [
                'publishers' => $publishers,
                'searchName' => $searchName,
                'searchValue' => $searchValue,
                'publisher' => $publisher,
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

        return view('publishers.create', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('New publisher'),
            'supportedImageFormats' => Publisher::returnImageSupportedFormatsString()
        ]);
    }

    public function store(Request $request, Publisher $publisher)
    {
        $formFields = $request->validate([
            'name_en' => 'required',
            'name_it' => '',
            'description_en' => '',
            'description_it' => '',
            'logo' => Publisher::returnImageValidationString()
        ]);

        if ($request->hasFile('logo')) {
            $logo = $publisher->uploadImage();
            $formFields['logo'] = $logo;
        }

        if ($newPublisher = Publisher::create($formFields)) {
            return redirect(route('publishers.edit', $newPublisher))->with('confirm', _('Publisher created'));
        } else {
            return redirect(route('publishers.create'))->with('error', _('Error creating publisher'));
        }

    }

    public function show(Publisher $publisher)
    {
        self::$templateStylesheets[] = '/css/publishers.css';

        $numberOfGames = Game::where('publisher_id', $publisher->id)->count('publisher_id') or 0;

        $image = null;
        
        if (!empty($publisher->image)) {
            $image = \Image::make(\Storage::disk('public')->get($publisher->image));
        }

        return view('publishers.show', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => sprintf(_('Publisher: %s'), $publisher->name),
            'publisher' => $publisher,
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
    public function edit(Publisher $publisher)
    {
        self::$templateStylesheets[] = '/css/forms.css';

        $logo = null;
        
        if (!empty($publisher->logo)) {
            $logo = \Image::make(\Storage::disk('public')->get($publisher->logo));
        }

        return view('publishers.edit', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Edit publisher'),
            'publisher' => $publisher,
            'image' => $logo,
            'supportedImageFormats' => Publisher::returnImageSupportedFormatsString()
        ]);
    }

    public function update(Request $request, Publisher $publisher)
    {
        $formFields = $request->validate([
            'name_en' => 'required',
            'name_it' => '',
            'description_en' => '',
            'description_it' => '',
            'logo' => Publisher::returnImageValidationString()
        ]);

        if ($request->hasFile('logo')) {
            if ($publisher->logo) {
                Storage::delete($publisher->logo);
            }

            $logo = $publisher->uploadImage();
            $formFields['logo'] = $logo;
        }

        if ($publisher->update($formFields)) {
            return redirect(route('publishers.edit', $publisher))->with('confirm', _('Publisher updated'));
        } else {
            return redirect(route('publishers.edit', $publisher))->with('error', _('Error updating the publisher'));
        }

    }

    public function destroy(Publisher $publisher)
    {
        $imageToDelete = null;

        if ($publisher->logo) {
            $imageToDelete = $publisher->logo;
        }

        if ($publisher->delete()) {
            if ($imageToDelete) {
                Storage::delete($imageToDelete);
            }
            
            return redirect(route('publishers.index'))->with('confirm', _('Publisher deleted'));
        } else {
            return redirect(route('publishers.edit', $publisher))->with('error', _('Error deleting publisher'));
        }

    }
}
