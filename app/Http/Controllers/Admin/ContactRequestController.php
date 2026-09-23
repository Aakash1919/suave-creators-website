<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ContactRequestDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Services\ContactRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactRequestController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly ContactRequestService $contacts,
    ) {}

    /**
     * Render contact requests index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, ContactRequestDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        return view('admin.contacts.index', [
            'columns' => ContactRequestDataTable::columns(),
        ]);
    }

    /**
     * Show a contact request and mark it read when still new.
     *
     * Returns JSON (with rendered detail HTML) for the index page's view modal;
     * falls back to the full page for direct navigation.
     */
    public function show(Request $request, ContactRequest $contact): View|JsonResponse
    {
        $contact = $this->contacts->markRead($contact);

        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return response()->json([
                'success' => true,
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->displayName(),
                    'email_display' => trim((string) $contact->email) !== '' ? $contact->email : 'No email yet',
                    'service' => $contact->serviceLabel(),
                    'status_label' => match ($contact->status) {
                        ContactRequest::STATUS_DRAFT => 'Incomplete',
                        ContactRequest::STATUS_READ => 'Read',
                        ContactRequest::STATUS_ARCHIVED => 'Archived',
                        default => 'New',
                    },
                    'can_archive' => $contact->status !== ContactRequest::STATUS_ARCHIVED,
                    'archive_url' => route('admin.contacts.archive', $contact),
                    'destroy_url' => route('admin.contacts.destroy', $contact),
                    'detail_html' => view('admin.contacts.partials.detail', ['contact' => $contact])->render(),
                ],
            ]);
        }

        return view('admin.contacts.show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Mark a contact request as archived.
     */
    public function archive(Request $request, ContactRequest $contact): JsonResponse|RedirectResponse
    {
        $this->contacts->archive($contact);

        return $this->adminSuccess($request, 'Contact request', 'updated', 'admin.contacts.index');
    }

    /**
     * Delete a contact request.
     */
    public function destroy(Request $request, ContactRequest $contact): JsonResponse|RedirectResponse
    {
        $this->contacts->delete($contact);

        return $this->adminSuccess($request, 'Contact request', 'deleted', 'admin.contacts.index');
    }
}
