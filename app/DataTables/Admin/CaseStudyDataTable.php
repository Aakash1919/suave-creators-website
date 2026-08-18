<?php

namespace App\DataTables\Admin;

use App\Models\CaseStudy;
use App\Models\User;
use App\Support\Admin\DataTableActions;
use App\Support\Admin\DateRangeFilter;
use App\Support\Frontend\CaseStudySupport;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CaseStudyDataTable
{
    /**
     * Build the server-side case studies DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<CaseStudy> $query */
        $query = CaseStudy::query()->select('case_studies.*');

        return DataTables::eloquent($query)
            ->editColumn('title', function (CaseStudy $caseStudy): string {
                $title = e($caseStudy->title);
                $slug = e($caseStudy->slug);
                $titleHtml = $title;

                if ($caseStudy->slug !== '') {
                    $url = e(CaseStudySupport::urlForSlug((string) $caseStudy->slug));
                    $titleHtml = '<a href="'.$url.'" target="_blank" rel="noopener noreferrer" class="admin-table__title-link">'.$title.'</a>';
                }

                $meta = trim((string) ($caseStudy->industry ?? ''));

                return '<div class="admin-table__title">'.$titleHtml.'</div>'
                    .'<div class="admin-table__meta">'.e($meta !== '' ? $meta : $slug).'</div>';
            })
            ->editColumn('status', function (CaseStudy $caseStudy): string {
                $class = $caseStudy->status === CaseStudy::STATUS_PUBLISHED
                    ? 'admin-badge--success'
                    : 'admin-badge--warning';

                return '<span class="admin-badge '.$class.'">'.e($caseStudy->status).'</span>';
            })
            ->editColumn('published_at', fn (CaseStudy $caseStudy): string => optional($caseStudy->published_at)->format('Y-m-d H:i') ?? '—')
            ->editColumn('updated_at', fn (CaseStudy $caseStudy): string => optional($caseStudy->updated_at)?->diffForHumans() ?? '—')
            ->addColumn('actions', function (CaseStudy $caseStudy): string {
                $items = [];
                /** @var User|null $user */
                $user = Auth::user();

                if ($user?->hasPermission('case-studies.update')) {
                    $items[] = [
                        'label' => 'Edit',
                        'url' => route('admin.case-studies.edit', $caseStudy),
                    ];
                }

                if ($user?->hasPermission('case-studies.delete')) {
                    $name = trim((string) $caseStudy->title) !== '' ? (string) $caseStudy->title : 'this case study';
                    $items[] = [
                        'label' => 'Delete',
                        'url' => route('admin.case-studies.destroy', $caseStudy),
                        'delete' => true,
                        'confirmTitle' => 'Delete case study?',
                        'confirm' => 'Are you sure want to delete case study '.$name.'?',
                    ];
                }

                return DataTableActions::menu($items);
            })
            ->filter(function (EloquentBuilder $query) use ($request): void {
                $status = trim((string) $request->input('status_filter', ''));
                if (in_array($status, [CaseStudy::STATUS_DRAFT, CaseStudy::STATUS_PUBLISHED], true)) {
                    $query->where('case_studies.status', $status);
                }

                DateRangeFilter::apply($query, $request, 'case_studies.updated_at');
            }, true)
            ->orderColumn('actions', false)
            ->rawColumns(['title', 'status', 'actions'])
            ->toJson();
    }

    /**
     * Configure the DataTable column definitions.
     *
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'sort_order', 'name' => 'sort_order', 'title' => 'Order'],
            ['data' => 'published_at', 'name' => 'published_at', 'title' => 'Published'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }
}
