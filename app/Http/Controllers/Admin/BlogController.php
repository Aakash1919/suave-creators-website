<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\BlogDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Services\BlogService;
use App\Services\BlogSeoMetaGenerationService;
use App\Support\Admin\BlogCompleteness;
use App\Support\Blogs\BlogInternalLinks;
use App\Support\Frontend\BlogSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class BlogController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly BlogService $blogs,
        private readonly BlogSeoMetaGenerationService $seoMeta,
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
        $blog = $this->blogs->newDraft();

        return view('admin.blogs.form', [
            'blog' => $blog,
            'categories' => $this->blogs->categories(),
            'editorContent' => '',
            'completeness' => BlogCompleteness::evaluate($blog),
            'internalLinkSuggestions' => BlogInternalLinks::suggest(
                title: (string) $blog->title,
                content: '',
                limit: 3,
            ),
        ]);
    }

    /**
     * Persist a new blog post and optional featured image.
     */
    public function store(BlogStoreRequest $request): JsonResponse|RedirectResponse
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
        $blog->content = BlogSupport::normalizeVisualHtml((string) $blog->content);

        return view('admin.blogs.form', [
            'blog' => $blog,
            'categories' => $this->blogs->categories(),
            'editorContent' => (string) $blog->content,
            'completeness' => BlogCompleteness::evaluate($blog),
            'internalLinkSuggestions' => BlogInternalLinks::suggest(
                title: (string) $blog->title,
                content: (string) $blog->content,
                excludeBlogId: $blog->id,
                limit: 3,
            ),
        ]);
    }

    /**
     * Update a blog post and replace the featured image when uploaded.
     */
    public function update(BlogUpdateRequest $request, Blog $blog): JsonResponse|RedirectResponse
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

    /**
     * Generate SEO / OG field suggestions for the edit form (does not save).
     */
    public function generateSeoMeta(Request $request, Blog $blog): JsonResponse|RedirectResponse
    {
        $blog->loadMissing('category');

        try {
            $seo = $this->seoMeta->generate($blog, $request->only([
                'title',
                'short_description',
                'content',
            ]));
        } catch (RuntimeException $e) {
            return $this->adminError($request, $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return $this->adminError($request, 'Unable to generate SEO meta right now. Please try again.');
        }

        $message = 'SEO meta generated. Review the fields and save when ready.';

        if ($this->wantsAdminJson($request)) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'seo' => $seo,
            ]);
        }

        return back()->with('status', $message)->withInput(array_merge($request->all(), $seo));
    }
}
