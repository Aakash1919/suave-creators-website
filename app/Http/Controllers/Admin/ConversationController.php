<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ConversationDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Models\ChatLead;
use App\Services\ConversationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConversationController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly ConversationService $conversations,
    ) {}

    /**
     * Render chat leads index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, ConversationDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        return view('admin.conversations.index', [
            'columns' => ConversationDataTable::columns(),
        ]);
    }

    /**
     * Show a lead's AI conversation threads with Markdown-rendered assistant replies.
     */
    public function show(ChatLead $lead): View
    {
        $threads = $this->conversations->threadsForLead($lead);

        return view('admin.conversations.show', [
            'lead' => $lead,
            'threads' => $threads,
            'leadInitials' => $this->conversations->initialsFor($lead->name),
        ]);
    }
}
