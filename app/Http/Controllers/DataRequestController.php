<?php

namespace App\Http\Controllers;

use App\Models\DataRequest;
use Illuminate\Http\Request;
use App\Mail\DataRequestToUser;
use App\Mail\DataRequestToAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

class DataRequestController extends Controller
{
    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('datarequests.create', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Send us a request'),
            'requestTypes' => DataRequest::getTypes()
        ]);
    }

    public function store(Request $request, DataRequest $dataRequest)
    {
        $formFields = $request->validate([
            'type' => 'required|integer',
            'title' => 'required|max:150',
            'description' => 'min:10|max:2000',
            'email' => 'email',
            'notes' => 'min:5|max:500'
        ]);

        $requestTypes = DataRequest::getTypes();

        $emailSent = false;

        $emailBody = sprintf(_('Title: %s'), htmlspecialchars($formFields['title']));
        $emailBody .= "\n" . sprintf(_('Type: %s'), $requestTypes[intval($formFields['type'])]);

        if (!empty($formFields['description'])) {
            $emailBody .= "\n" . sprintf(_('Description: %s'), htmlspecialchars($formFields['description']));
        }

        if (!empty($formFields['email'])) {
            $emailBody .= "\n" . sprintf(_('Email: %s'), htmlspecialchars($formFields['email']));
        }

        if (!empty($formFields['notes'])) {
            $emailBody .= "\n" . sprintf(_('Notes: %s'), htmlspecialchars($formFields['notes']));
        }

        if ($formFields['email']) {
            Mail::to($formFields['email'])
            ->send(new DataRequestToUser($emailBody));
        }

        Mail::to(env('APP_EMAIL_PUBLIC'))->send(new DataRequestToAdmin($emailBody, $formFields['email']));

        if ($newDataRequest = DataRequest::create($formFields)) {
            return back()->with('confirm', _('Thank you! We will look into your data request as soon as possible!'));
        } else {
            return back()->with('error', sprintf(_('There was an error with your request, please try again or send us an email at: %s'), env('APP_EMAIL_PUBLIC')))->withInput();
        }

    }
}
