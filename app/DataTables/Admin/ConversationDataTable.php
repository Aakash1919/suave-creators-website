<?php

namespace App\DataTables\Admin;

use App\Models\ChatLead;
use App\Support\Admin\DataTableActions;
use App\Support\Admin\DateRangeFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ConversationDataTable
{
    /**
     * Build the server-side chat leads DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<ChatLead> $query */
        $query = ChatLead::query()
            ->withCount('conversations')
            ->select('chat_leads.*');

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
            ->addColumn('conversations_count', fn (ChatLead $lead): int => (int) ($lead->conversations_count ?? 0))
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
            ->orderColumn('conversations_count', 'conversations_count $1')
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
            ['data' => 'conversations_count', 'name' => 'conversations_count', 'title' => 'Conversations', 'searchable' => false, 'defaultContent' => '0'],
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
