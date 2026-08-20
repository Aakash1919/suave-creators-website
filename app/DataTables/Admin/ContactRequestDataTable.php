<?php

namespace App\DataTables\Admin;

use App\Models\ContactRequest;
use App\Support\Admin\DataTableActions;
use App\Support\Admin\DateRangeFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactRequestDataTable
{
    /**
     * Build the server-side contact requests DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<ContactRequest> $query */
        $query = ContactRequest::query()->select('contact_requests.*');

        return DataTables::eloquent($query)
            ->editColumn('name', function (ContactRequest $contact): string {
                $meta = trim((string) $contact->email) !== ''
                    ? $contact->email
                    : (trim((string) $contact->phone) !== '' ? $contact->phone : 'Left the form before sending');

                return '<div class="admin-table__person">'
                    .'<span class="admin-table__avatar" aria-hidden="true">'.e(self::initials((string) ($contact->name ?? ''))).'</span>'
                    .'<div>'
                    .'<div class="admin-table__title">'.e($contact->displayName()).'</div>'
                    .'<div class="admin-table__meta">'.e($meta).'</div>'
                    .'</div>'
                    .'</div>';
            })
            ->editColumn('phone', fn (ContactRequest $contact): string => e(trim((string) $contact->phone) !== '' ? $contact->phone : '—'))
            ->editColumn('service', fn (ContactRequest $contact): string => e($contact->serviceLabel()))
            ->editColumn('status', function (ContactRequest $contact): string {
                return match ($contact->status) {
                    ContactRequest::STATUS_DRAFT => '<span class="admin-badge admin-badge--warning">Incomplete</span>',
                    ContactRequest::STATUS_READ => '<span class="admin-badge admin-badge--muted">Read</span>',
                    ContactRequest::STATUS_ARCHIVED => '<span class="admin-badge">Archived</span>',
                    default => '<span class="admin-badge admin-badge--success">New</span>',
                };
            })
            ->editColumn('created_at', fn (ContactRequest $contact): string => optional($contact->created_at)?->diffForHumans() ?? '—')
            ->addColumn('actions', function (ContactRequest $contact): string {
                return DataTableActions::menu([
                    [
                        'label' => 'View',
                        'url' => route('admin.contacts.show', $contact),
                    ],
                ]);
            })
            ->filter(function (EloquentBuilder $query) use ($request): void {
                $status = (string) $request->input('status', '');
                if (in_array($status, [
                    ContactRequest::STATUS_DRAFT,
                    ContactRequest::STATUS_NEW,
                    ContactRequest::STATUS_READ,
                    ContactRequest::STATUS_ARCHIVED,
                ], true)) {
                    $query->where('contact_requests.status', $status);
                }

                DateRangeFilter::apply($query, $request, 'contact_requests.created_at');
            }, true)
            ->orderColumn('actions', false)
            ->rawColumns(['name', 'status', 'actions'])
            ->toJson();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Contact'],
            ['data' => 'phone', 'name' => 'phone', 'title' => 'Phone'],
            ['data' => 'service', 'name' => 'service', 'title' => 'Service'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Received'],
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
