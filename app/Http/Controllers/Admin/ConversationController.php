<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ConversationDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Models\ChatLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConversationController extends Controller
{
    use RespondsToAdminAjax;

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
        $conversations = $lead->conversations()
            ->with(['messages' => fn ($q) => $q->orderBy('created_at')])
            ->latest('updated_at')
            ->get();

        $threads = $conversations->map(function ($conversation) {
            $messages = $conversation->messages
                ->filter(fn ($message): bool => in_array($message->role, ['user', 'assistant'], true))
                ->filter(fn ($message): bool => filled($message->content))
                ->reject(fn ($message): bool => $message->role === 'user' && str_starts_with((string) $message->content, 'Hello. My name is'))
                ->values()
                ->map(function ($message): array {
                    $content = (string) $message->content;
                    $html = $message->role === 'assistant'
                        ? Str::markdown($content, [
                            'html_input' => 'strip',
                            'allow_unsafe_links' => false,
                        ])
                        : e($content);

                    return [
                        'id' => $message->id,
                        'role' => $message->role,
                        'content' => $content,
                        'html' => $html,
                        'created_at' => $message->created_at,
                    ];
                });

            return [
                'id' => $conversation->id,
                'title' => $conversation->title,
                'updated_at' => $conversation->updated_at,
                'messages' => $messages,
            ];
        });

        return view('admin.conversations.show', [
            'lead' => $lead,
            'threads' => $threads,
        ]);
    }
}
