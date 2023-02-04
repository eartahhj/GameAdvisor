<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publisherId = $request->input('publisher');
        $searchName = $request->input('name');
        $responseCode = 200;
        $publisher = null;

        $publishers = DB::table('publishers')
        ->when($searchName, function($query, $searchName) {
            $query->where('name', 'LIKE', "%$searchName%");
        })
        ->get();

        if (!$publishers->isEmpty()) {
            if ($publisherId !== false) {
                $publisher = $publishers->where('id', $publisherId)->first();
            }
        } else {
            $responseCode = 404;
        }

        self::$templateStylesheets[] = '/css/publishers.css';

        return response()->view(
            'publishers.index',
            [
                'publishers' => $publishers,
                'searchName' => $searchName,
                'publisher' => $publisher,
                'templateStylesheets' => static::$templateStylesheets,
                'templateJavascripts' => static::$templateJavascripts
            ],
            $responseCode
        );
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('publishers.create', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($newPublisher = Publisher::create($formFields)) {
            return redirect(route('publishers.edit', $newPublisher))->with('confirm', _('Publisher created'));
        } else {
            return redirect(route('publishers.create'))->with('error', _('Error creating publisher'));
        }

    }

    public function show(Publisher $publisher)
    {
        self::$templateStylesheets[] = '/css/publishers.css';

        return view('publishers.show', compact('publisher') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
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

        return view('publishers.edit', compact('publisher') + ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function update(Request $request, Publisher $publisher)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($publisher->update($formFields)) {
            return redirect(route('publishers.edit', $publisher))->with('confirm', _('Publisher updated'));
        } else {
            return redirect(route('publishers.edit', $publisher))->with('error', _('Error updating the publisher'));
        }

    }

    public function destroy(Publisher $publisher)
    {
        if ($publisher->delete()) {
            return redirect(route('publishers.index'))->with('confirm', _('Publisher deleted'));
        } else {
            return redirect(route('publishers.edit', $publisher))->with('error', _('Error deleting publisher'));
        }

    }
}
