<?php

namespace App\DataTables\Admin;

use App\Models\ChatLead;
use App\Support\Admin\DataTableActions;
use App\Support\Admin\DateRangeFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ConversationDataTable
{
    /**
     * Build the server-side chat leads DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        $conversationsTable = config('ai.conversations.tables.conversations', 'agent_conversations');
        $messagesTable = config('ai.conversations.tables.messages', 'agent_conversation_messages');
        $participantType = (new ChatLead)->getMorphClass();

        /** @var EloquentBuilder<ChatLead> $query */
        $query = ChatLead::query()
            ->select('chat_leads.*')
            ->addSelect([
                'messages_count' => DB::table($messagesTable.' as acm')
                    ->join($conversationsTable.' as ac', 'ac.id', '=', 'acm.conversation_id')
                    ->whereColumn('ac.participant_id', 'chat_leads.id')
                    ->where('ac.participant_type', $participantType)
                    ->whereIn('acm.role', ['user', 'assistant'])
                    ->where('acm.content', '!=', '')
                    ->where('acm.content', 'not like', 'Hello. My name is%')
                    ->selectRaw('count(*)'),
            ]);

        return DataTables::eloquent($query)
            ->editColumn('name', function (ChatLead $lead): string {
                return '<div class="admin-table__person">'
                    .'<span class="admin-table__avatar" aria-hidden="true">'.e(self::initials($lead->name)).'</span>'
                    .'<div>'
                    .'<div class="admin-table__title">'.e($lead->name).'</div>'
                    .'<div class="admin-table__meta">'.e($lead->email).'</div>'
                    .'</div>'
                    .'</div>';
            })
            ->editColumn('messages_count', fn (ChatLead $lead): int => (int) ($lead->messages_count ?? 0))
            ->addColumn('escalated', function (ChatLead $lead): string {
                if ($lead->escalated_at) {
                    return '<span class="admin-badge admin-badge--danger">Yes</span>';
                }

                return '<span class="admin-badge admin-badge--muted">No</span>';
            })
            ->editColumn('updated_at', fn (ChatLead $lead): string => optional($lead->updated_at)?->diffForHumans() ?? '—')
            ->addColumn('actions', function (ChatLead $lead): string {
                return DataTableActions::menu([
                    [
                        'label' => 'View',
                        'url' => route('admin.conversations.show', $lead),
                    ],
                ]);
            })
            ->filter(function (EloquentBuilder $query) use ($request): void {
                if ($request->boolean('escalated_only')) {
                    $query->whereNotNull('chat_leads.escalated_at');
                }

                DateRangeFilter::apply($query, $request, 'chat_leads.updated_at');
            }, true)
            ->orderColumn('messages_count', 'messages_count $1')
            ->orderColumn('escalated', 'escalated_at $1')
            ->orderColumn('actions', false)
            ->rawColumns(['name', 'escalated', 'actions'])
            ->toJson();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Lead'],
            ['data' => 'messages_count', 'name' => 'messages_count', 'title' => 'Messages', 'searchable' => false, 'defaultContent' => '0'],
            ['data' => 'escalated', 'name' => 'escalated_at', 'title' => 'Escalated'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }

    private static function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name) ?: 'SC') ?: ['SC'];

        return collect($parts)
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr((string) $part, 0, 1)))
            ->implode('') ?: 'SC';
    }
}
