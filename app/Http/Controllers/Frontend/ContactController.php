<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\ContactDraftRequest;
use App\Http\Requests\Frontend\ContactStoreRequest;
use App\Services\ContactRequestService;
use App\Support\Frontend\ContactSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
    public function store(ContactStoreRequest $request): JsonResponse|RedirectResponse
    {
        $wantsJson = $request->ajax() || $request->expectsJson() || $request->boolean('_ajax');

        if ($this->contacts->isBotSubmission($request)) {
            if ($wantsJson) {
                return response()->json([
                    'success' => true,
                    'message' => ContactRequestService::SUCCESS_MESSAGE,
                ]);
            }

            createFlashMessage('Contact request', 'created');

            return redirect()->route('contact-us')->withFragment('contact-id');
        }

        $this->contacts->store($request);

        if ($wantsJson) {
            return response()->json([
                'success' => true,
                'message' => ContactRequestService::SUCCESS_MESSAGE,
            ]);
        }

        createFlashMessage('Contact request', 'created');

        return redirect()->route('contact-us')->withFragment('contact-id');
    }

    /**
     * Silently persist a field-by-field draft so abandoned forms still capture leads.
     */
    public function draft(ContactDraftRequest $request): JsonResponse
    {
        $contact = $this->contacts->saveDraft($request);

        return response()->json([
            'success' => true,
            'draft_token' => $contact?->draft_token,
        ]);
    }

    public function quickConsultation(\App\Http\Requests\Frontend\QuickConsultationRequest $request): JsonResponse|RedirectResponse
    {
        $wantsJson = $request->ajax() || $request->expectsJson() || $request->boolean('_ajax');

        if ($this->contacts->isBotSubmission($request)) {
            if ($wantsJson) {
                return response()->json([
                    'success' => true,
                ]);
            }

            createFlashMessage('Consultation request', 'created');

            return back();
        }

        $this->contacts->storeQuickConsultation($request);

        $contact = (string) $request->input('contact');
        $chatSession = SuaveAgentController::createLeadSession('', $contact);

        if ($wantsJson) {
            return response()->json([
                'success' => true,
                'chat_session' => $chatSession,
            ]);
        }

        createFlashMessage('Consultation request', 'created');

        return back();
    }
}
