<?php

namespace App\DataTables\Admin;

use App\Models\Blog;
use App\Support\Admin\DataTableActions;
use App\Support\Admin\DateRangeFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogDataTable
{
    /**
     * Build the server-side blogs DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<Blog> $query */
        $query = Blog::query()
            ->with(['category', 'createdBy'])
            ->select('blogs.*');

        return DataTables::eloquent($query)
            ->addColumn('category_name', fn (Blog $blog): string => e($blog->category?->name ?? '—'))
            ->editColumn('title', function (Blog $blog): string {
                $title = e($blog->title);
                $slug = e($blog->slug);
                $titleHtml = $title;

                if ($blog->slug !== '') {
                    $url = e(route('blog.show', ['slug' => $blog->slug]));
                    $titleHtml = '<a href="'.$url.'" target="_blank" rel="noopener noreferrer" class="admin-table__title-link">'.$title.'</a>';
                }

                return '<div class="admin-table__title">'.$titleHtml.'</div>'
                    .'<div class="admin-table__meta">'.$slug.'</div>';
            })
            ->editColumn('status', function (Blog $blog): string {
                $class = $blog->status === Blog::STATUS_PUBLISHED
                    ? 'admin-badge--success'
                    : 'admin-badge--warning';

                return '<span class="admin-badge '.$class.'">'.e($blog->status).'</span>';
            })
            ->editColumn('published_at', fn (Blog $blog): string => optional($blog->published_at)->format('Y-m-d H:i') ?? '—')
            ->editColumn('updated_at', fn (Blog $blog): string => optional($blog->updated_at)?->diffForHumans() ?? '—')
            ->addColumn('actions', function (Blog $blog): string {
                $items = [];

                if (Auth::user()?->hasPermission('blogs.update')) {
                    $items[] = [
                        'label' => 'Edit',
                        'url' => route('admin.blogs.edit', $blog),
                    ];
                }

                if (Auth::user()?->hasPermission('blogs.delete')) {
                    $name = trim((string) $blog->title) !== '' ? (string) $blog->title : 'this blog';
                    $items[] = [
                        'label' => 'Delete',
                        'url' => route('admin.blogs.destroy', $blog),
                        'delete' => true,
                        'confirmTitle' => 'Delete blog?',
                        'confirm' => 'Are you sure want to delete blog '.$name.'?',
                    ];
                }

                return DataTableActions::menu($items);
            })
            ->filter(function (EloquentBuilder $query) use ($request): void {
                $status = trim((string) $request->input('status_filter', ''));
                if (in_array($status, [Blog::STATUS_DRAFT, Blog::STATUS_PUBLISHED], true)) {
                    $query->where('blogs.status', $status);
                }

                $categoryId = (int) $request->input('category_filter', 0);
                if ($categoryId > 0) {
                    $query->where('blogs.blog_category_id', $categoryId);
                }

                DateRangeFilter::apply($query, $request, 'blogs.updated_at');
            }, true)
            ->orderColumn('category_name', false)
            ->orderColumn('actions', false)
            ->rawColumns(['title', 'status', 'actions'])
            ->toJson();
    }

    /**
     * Configure the client DataTable column definitions.
     *
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'category_name', 'name' => 'category.name', 'title' => 'Category', 'orderable' => false],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'published_at', 'name' => 'published_at', 'title' => 'Published'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }
}
