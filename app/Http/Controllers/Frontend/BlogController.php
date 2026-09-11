<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BlogCategory;
use App\Support\Frontend\BlogSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends FrontendController
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->redirectAwayFromPageQuery($request)) {
            return $redirect;
        }

        return $this->view(
            'frontend.blogs',
            BlogSupport::indexData(
                $this->categorySlugFromRequest($request),
                1,
                $this->searchFromRequest($request),
                $this->perPageFromRequest($request)
            )
        );
    }

    public function category(Request $request, string $slug): View|RedirectResponse
    {
        $hasPublishedPosts = BlogCategory::query()
            ->where('slug', $slug)
            ->whereHas('blogs', static function ($query): void {
                $query->published();
            })
            ->exists();

        if (! $hasPublishedPosts) {
            return redirect()->route('blogs', status: 301);
        }

        if ($redirect = $this->redirectAwayFromPageQuery($request)) {
            return $redirect;
        }

        return $this->view(
            'frontend.blogs',
            BlogSupport::indexData(
                $slug,
                1,
                $this->searchFromRequest($request),
                $this->perPageFromRequest($request)
            )
        );
    }

    public function filter(Request $request): JsonResponse
    {
        $categorySlug = $this->categorySlugFromRequest($request);
        $search = $this->searchFromRequest($request);
        $page = max(1, (int) $request->query('page', 1));

        if ($categorySlug !== null && $categorySlug !== '') {
            $exists = \App\Models\BlogCategory::query()->where('slug', $categorySlug)->exists();
            if (! $exists) {
                return response()->json(['message' => 'Category not found.'], 404);
            }
        }

        $data = BlogSupport::indexData($categorySlug, $page, $search, $this->perPageFromRequest($request));
        $data['paginator']->withPath(route('blogs', absolute: false));

        return response()->json([
            'html' => view('frontend.partials.blog-posts', [
                'posts' => $data['posts'],
                'paginator' => $data['paginator'],
                'activeCategory' => $data['activeCategory'],
                'search' => $data['search'],
                'listingUrl' => $data['listingUrl'],
            ])->render(),
            'meta' => [
                'total' => $data['paginator']->total(),
                'page' => $data['paginator']->currentPage(),
                'last_page' => $data['paginator']->lastPage(),
                'category' => $categorySlug,
                'q' => $search,
            ],
        ]);
    }

    public function show(string $slug): View
    {
        return $this->view('frontend.single-blog', BlogSupport::showData($slug));
    }

    protected function categorySlugFromRequest(Request $request): ?string
    {
        $slug = trim((string) $request->query('category', ''));

        return $slug !== '' ? $slug : null;
    }

    protected function searchFromRequest(Request $request): ?string
    {
        $search = trim((string) $request->query('q', ''));

        return $search !== '' ? $search : null;
    }

    protected function perPageFromRequest(Request $request): int
    {
        return BlogSupport::perPage((int) $request->query('per_page', BlogSupport::PER_PAGE));
    }

    /**
     * Drop crawlable ?page= URLs so paginated listings do not create duplicate SEO signals.
     * Page changes stay AJAX-only via blogs.filter.
     */
    protected function redirectAwayFromPageQuery(Request $request): ?RedirectResponse
    {
        if (! $request->query->has('page')) {
            return null;
        }

        $query = $request->query();
        unset($query['page'], $query['per_page']);

        $target = $request->url();
        if ($query !== []) {
            $target .= '?'.http_build_query($query);
        }

        return redirect()->to($target, 301);
    }
}
