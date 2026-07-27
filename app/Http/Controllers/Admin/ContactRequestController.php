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
     */
    public function show(ContactRequest $contact): View
    {
        $contact = $this->contacts->markRead($contact);

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
}
