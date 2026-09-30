<?php

namespace App\DataTables\Admin;

use App\Models\BlogCategory;
use App\Support\Admin\DataTableActions;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryDataTable
{
    /**
     * Build the server-side blog categories DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<BlogCategory> $query */
        $query = BlogCategory::query()
            ->select([
                'blog_categories.id',
                'blog_categories.name',
                'blog_categories.slug',
                'blog_categories.sort_order',
            ])
            ->withCount('blogs');

        return DataTables::eloquent($query)
            ->editColumn('name', fn (BlogCategory $category): string => e($category->name))
            ->editColumn('slug', fn (BlogCategory $category): string => e($category->slug))
            ->editColumn('sort_order', fn (BlogCategory $category): string => (string) $category->sort_order)
            ->editColumn('blogs_count', fn (BlogCategory $category): string => (string) $category->blogs_count)
            ->addColumn('actions', function (BlogCategory $category): string {
                if (! Auth::user()?->hasPermission('blog-categories.update')) {
                    return '—';
                }

                return DataTableActions::menu([
                    [
                        'label' => 'Edit',
                        'button' => true,
                        'attrs' => [
                            'data-blog-category-edit' => true,
                            'data-url' => route('admin.blog-categories.edit', $category),
                        ],
                    ],
                ]);
            })
            ->orderColumn('actions', false)
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'slug', 'name' => 'slug', 'title' => 'Slug'],
            ['data' => 'sort_order', 'name' => 'sort_order', 'title' => 'Order'],
            ['data' => 'blogs_count', 'name' => 'blogs_count', 'title' => 'Posts', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }
}
