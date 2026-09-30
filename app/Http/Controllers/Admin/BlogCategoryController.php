<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\BlogCategoryDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryStoreRequest;
use App\Http\Requests\Admin\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Services\BlogCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly BlogCategoryService $categories,
    ) {}

    /**
     * Render the blog categories index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, BlogCategoryDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        $draft = $this->categories->newCategory();

        return view('admin.blog-categories.index', [
            'columns' => BlogCategoryDataTable::columns(),
            'canCreate' => $request->user()->hasPermission('blog-categories.create'),
            'canUpdate' => $request->user()->hasPermission('blog-categories.update'),
            'defaults' => [
                'name' => '',
                'slug' => '',
                'sort_order' => (int) $draft->sort_order,
            ],
        ]);
    }

    /**
     * Return JSON defaults for the create modal (no dedicated create page).
     */
    public function create(Request $request): JsonResponse|RedirectResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            $draft = $this->categories->newCategory();

            return response()->json([
                'success' => true,
                'category' => [
                    'name' => '',
                    'slug' => '',
                    'sort_order' => (int) $draft->sort_order,
                ],
            ]);
        }

        return redirect()->route('admin.blog-categories.index');
    }

    /**
     * Create a blog category (modal AJAX; stay on index).
     */
    public function store(BlogCategoryStoreRequest $request): JsonResponse|RedirectResponse
    {
        $category = $this->categories->create($request);

        return $this->adminSuccess(
            $request,
            'Blog category',
            'created',
            'admin.blog-categories.index',
            [],
            ['category' => ['id' => $category->id]]
        );
    }

    /**
     * Return JSON payload for the edit modal (no dedicated edit page).
     */
    public function edit(Request $request, BlogCategory $blogCategory): JsonResponse|RedirectResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return response()->json([
                'success' => true,
                'category' => [
                    'id' => $blogCategory->id,
                    'name' => $blogCategory->name,
                    'slug' => $blogCategory->slug,
                    'sort_order' => (int) $blogCategory->sort_order,
                    'update_url' => route('admin.blog-categories.update', $blogCategory),
                ],
            ]);
        }

        return redirect()->route('admin.blog-categories.index');
    }

    /**
     * Update a blog category (modal AJAX; stay on index).
     */
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory): JsonResponse|RedirectResponse
    {
        $category = $this->categories->update($request, $blogCategory);

        return $this->adminSuccess(
            $request,
            'Blog category',
            'updated',
            'admin.blog-categories.index',
            [],
            ['category' => ['id' => $category->id]]
        );
    }
}
