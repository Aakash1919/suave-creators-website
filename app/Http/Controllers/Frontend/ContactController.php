<?php

namespace App\Http\Controllers\Frontend;

use App\Services\ContactRequestService;
use App\Support\Frontend\ContactSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends FrontendController
{
    public function __construct(
        private readonly ContactRequestService $contacts,
    ) {}

    /**
     * Show the contact page.
     */
    public function index(): View
    {
        return $this->view('frontend.contact-us', array_merge(ContactSupport::data(), [
            'formStartedAt' => time(),
        ]));
    }

    /**
     * Persist a contact inquiry (bots get a silent success and are not stored).
     */
    public function store(Request $request): RedirectResponse
    {
        if ($this->contacts->isBotSubmission($request)) {
            createFlashMessage('Contact request', 'created');

            return redirect()->route('contact-us')->withFragment('contact-id');
        }

        $this->contacts->store($request);

        createFlashMessage('Contact request', 'created');

        return redirect()->route('contact-us')->withFragment('contact-id');
    }
}
