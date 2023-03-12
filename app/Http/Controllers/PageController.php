<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        self::$templateJavascripts[] = '/js/tinymce/tinymce.min.js';
        self::$templateJavascripts[] = '/js/tinymce-init.js';

        return view('pages/create', ['templateJavascripts' => static::$templateJavascripts,
        'templateStylesheets' => static::$templateStylesheets, 'pageTitle' => _('Create a new page')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title_it' => 'required|min:5|max:191',
            'title_en' => 'required|min:5|max:191',
            'html_it' => 'required',
            'html_en' => 'required',
            'url_it' => '',
            'url_en' => ''
        ]);

        $formFields['user_creator_id'] = auth()->user()->id;

        foreach (config('app')['languages'] as $langCode => $langName) {
            if ($formFields['url_' . $langCode] === '' or empty($formFields['url_' . $langCode])) {
                $formFields['url_' . $langCode] = formatUrl($formFields['title_' . $langCode]);
            }
        }

        if ($newPage = Page::create($formFields)) {
            if ($request->hasFile('image')) {
                $fileFolder = 'images/pages';
                $fileName = 'page-' . $newPage->id . '-image.png';
                $filePath = $request->file('image')->storeAs($fileFolder, $fileName, 'public');

                if (!$newPage->update(['image' => $fileFolder . '/' . $fileName])) {
                    return redirect(route('pages.create'))->with('error', _('Error uploading image'));
                }
            }

            return redirect(route('pages.edit', $newPage))->with('confirm', _('Page created succesfully!'));
        } else {
            return redirect(route('pages.create'))->with('error', _('Error creating page'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uri
     * @return \Illuminate\Http\Response
     */
    public function show(string $uri)
    {
        $page = getPageByUri($uri);

        if (!$page) {
            abort(404);
        }

        $stringUrl = getPageUrlByUri($uri);
        if ($page->{'url_' . App::currentLocale()} != $stringUrl) {
            $redirect = route('pages.show', $page->id . '-' . $page->{'url_' . App::currentLocale()});
            return redirect($redirect);
        }

        if (!$page->published) {
            if (!auth()->user() or (auth()->user() and !auth()->user()->is_superadmin and $page->user_creator_id != auth()->user()->id)) {
                abort(404);
            }
        }

        $author = User::where('id', $page->user_creator_id)->first();

        $pageTitle = $page->title;

        return response()->view('pages.show', [
            'page' => $page,
            'pageTitle' => $pageTitle,
            'author' => $author
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);

        // TODO check permissions
        
        if (!auth()->user()->is_superadmin and $page->user_creator_id != auth()->user()->id) {
            abort(404);
        }

        self::$templateJavascripts[] = '/js/tinymce/tinymce.min.js';
        self::$templateJavascripts[] = '/js/tinymce-init.js';

        return view('pages/edit', ['page' => $page, 'templateJavascripts' => static::$templateJavascripts,
        'templateStylesheets' => static::$templateStylesheets, 'pageTitle' => _('Edit page')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $image = null;

        $formFields = $request->validate([
            'title_it' => 'required|min:5|max:191',
            'title_en' => 'required|min:5|max:191',
            'html_it' => 'required',
            'html_en' => 'required',
            'url_it' => '',
            'url_en' => ''
        ]);

        foreach (config('app')['languages'] as $langCode => $langName) {
            if ($page->{'url_' . $langCode} === '') {
                $page->{'url_' . $langCode} = formatUrl($page->{'title_' . $langCode});
            }
        }

        if (!$page->update($formFields)) {
            return back()->with('errors', $page->errors())->withInput();
        }

        if (!$page->wasChanged()) {
            return back()->with('info', _('No data has changed'))->withInput();
        }

        return redirect()->to(route('pages.edit', $page))->with('success', _('Page updated succesfully!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if ($page->delete()) {
            return redirect(route('admin.pages.index'))->with('confirm', _('Page deleted'));
        } else {
            return redirect(route('pages.edit', $pame))->with('error', _('Error deleting page'));
        }
    }

    public function publish(int $id)
    {
        if (!auth()->user()->is_superadmin) {
            abort(401);
        }

        if (request()->input('publish') == 1) {
            $published = true;
        } elseif (request()->input('unpublish') == 1) {
            $published = false;
        } else {
            return back()->with('error', _('An error occured during the approve/revoke operation'));
        }

        $pageId = request()->input('id');
        $page = Page::findOrFail($pageId);
        $page->published = $published;

        if ($page->save() === false) {
            return back()->with('errors', $page->errors());
        }

        if ($published) {
            $message = sprintf(_('Page #%s has been published'), $page->id);
        } else {
            $message = sprintf(_('Page #%s has been unpublished'), $page->id);
        }

        return back()->with('success', $message);
    }

    public function modifyCookieConsentView()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('pages/modifyCookieConsent', [
            'templateJavascripts' => static::$templateJavascripts,
            'templateStylesheets' => static::$templateStylesheets,
            'pageTitle' => _('Modify your consent to cookies'),
            'adsEnabled' => adsEnabled()
        ]);
    }

    public function modifyCookieConsentAction(Request $request)
    {
        $currentConsent = $_COOKIE['cookiesConsent'];
        $consentToAds = $request->input('ads');

        $consentsGiven = ['technical'];

        if (!empty($consentToAds)) {
            $consentsGiven[] = 'ads';
        }

        setcookie('cookiesConsent', implode(',', $consentsGiven), time()+60*60*24*180);

        return back()->with('success', _('Your consent to cookies has been updated!'));
    }
}
