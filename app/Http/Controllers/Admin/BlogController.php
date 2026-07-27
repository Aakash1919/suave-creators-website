<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\BlogDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly BlogService $blogs,
    ) {}

    /**
     * Render the blogs index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, BlogDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        return view('admin.blogs.index', [
            'columns' => BlogDataTable::columns(),
            'categories' => $this->blogs->categories(),
        ]);
    }

    /**
     * Show the create-blog form with categories.
     */
    public function create(): View
    {
        return view('admin.blogs.form', [
            'blog' => $this->blogs->newDraft(),
            'categories' => $this->blogs->categories(),
        ]);
    }

    /**
     * Persist a new blog post and optional featured image.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $blog = $this->blogs->create($request);

        return $this->adminSuccess(
            $request,
            'Blog',
            'created',
            'admin.blogs.edit',
            $blog,
            ['blog' => ['id' => $blog->id, 'slug' => $blog->slug]]
        );
    }

    /**
     * Show the edit form for an existing blog post.
     */
    public function edit(Blog $blog): View
    {
        return view('admin.blogs.form', [
            'blog' => $blog,
            'categories' => $this->blogs->categories(),
        ]);
    }

    /**
     * Update a blog post and replace the featured image when uploaded.
     */
    public function update(Request $request, Blog $blog): JsonResponse|RedirectResponse
    {
        $blog = $this->blogs->update($request, $blog);

        return $this->adminSuccess(
            $request,
            'Blog',
            'updated',
            'admin.blogs.edit',
            $blog,
            ['blog' => ['id' => $blog->id, 'slug' => $blog->slug]]
        );
    }

    /**
     * Soft-delete a blog post from the catalog.
     */
    public function destroy(Request $request, Blog $blog): JsonResponse|RedirectResponse
    {
        $this->blogs->delete($blog);

        return $this->adminSuccess($request, 'Blog', 'deleted', 'admin.blogs.index');
    }
}
