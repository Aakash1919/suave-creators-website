<?php

namespace App\DataTables\Admin;

use App\Models\Testimonial;
use App\Support\Admin\DataTableActions;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TestimonialDataTable
{
    /**
     * Build the server-side testimonials DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<Testimonial> $query */
        $query = Testimonial::query()->select('testimonials.*');

        return DataTables::eloquent($query)
            ->editColumn('name', function (Testimonial $testimonial): string {
                $initials = e($testimonial->displayInitials());

                return '<div class="admin-table__person">'
                    .'<span class="admin-table__avatar" aria-hidden="true">'.$initials.'</span>'
                    .'<div>'
                    .'<div class="admin-table__title">'.e($testimonial->name).'</div>'
                    .'<div class="text-xs text-[var(--admin-muted)]">'.e($testimonial->role).'</div>'
                    .'</div>'
                    .'</div>';
            })
            ->editColumn('quote', function (Testimonial $testimonial): string {
                return e(\Illuminate\Support\Str::limit($testimonial->quote, 90));
            })
            ->editColumn('is_published', function (Testimonial $testimonial): string {
                $class = $testimonial->is_published ? 'admin-badge--success' : 'admin-badge--muted';
                $label = $testimonial->is_published ? 'Published' : 'Draft';

                return '<span class="admin-badge '.$class.'">'.$label.'</span>';
            })
            ->editColumn('sort_order', fn (Testimonial $testimonial): string => (string) $testimonial->sort_order)
            ->addColumn('actions', function (Testimonial $testimonial): string {
                if (! Auth::user()?->hasPermission('testimonials.manage')) {
                    return '—';
                }

                return DataTableActions::menu([
                    [
                        'label' => 'Edit',
                        'button' => true,
                        'attrs' => [
                            'data-testimonial-edit' => true,
                            'data-url' => route('admin.testimonials.edit', $testimonial),
                        ],
                    ],
                    [
                        'label' => 'Delete',
                        'url' => route('admin.testimonials.destroy', $testimonial),
                        'delete' => true,
                        'confirm' => 'Delete testimonial from '.$testimonial->name.'?',
                        'confirmTitle' => 'Delete testimonial?',
                        'confirmLabel' => 'Delete',
                    ],
                ]);
            })
            ->filter(function (EloquentBuilder $query) use ($request): void {
                $status = trim((string) $request->input('status_filter', ''));
                if ($status === 'published') {
                    $query->where('testimonials.is_published', true);
                } elseif ($status === 'draft') {
                    $query->where('testimonials.is_published', false);
                }
            }, true)
            ->orderColumn('actions', false)
            ->rawColumns(['name', 'is_published', 'actions'])
            ->toJson();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Client'],
            ['data' => 'quote', 'name' => 'quote', 'title' => 'Quote', 'orderable' => false],
            ['data' => 'sort_order', 'name' => 'sort_order', 'title' => 'Order'],
            ['data' => 'is_published', 'name' => 'is_published', 'title' => 'Status'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }
}
