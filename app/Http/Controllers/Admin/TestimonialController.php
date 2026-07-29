<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TestimonialDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialStoreRequest;
use App\Http\Requests\Admin\TestimonialUpdateRequest;
use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly TestimonialService $testimonials,
    ) {}

    /**
     * Render the testimonials index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, TestimonialDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        $draft = $this->testimonials->newTestimonial();

        return view('admin.testimonials.index', [
            'columns' => TestimonialDataTable::columns(),
            'canManage' => $request->user()->hasPermission('testimonials.manage'),
            'defaults' => [
                'quote' => '',
                'name' => '',
                'role' => '',
                'sort_order' => (int) $draft->sort_order,
                'is_published' => true,
                'avatar_url' => null,
            ],
        ]);
    }

    /**
     * Return JSON defaults for the create modal (no dedicated create page).
     */
    public function create(Request $request): JsonResponse|RedirectResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            $draft = $this->testimonials->newTestimonial();

            return response()->json([
                'success' => true,
                'testimonial' => [
                    'quote' => '',
                    'name' => '',
                    'role' => '',
                    'sort_order' => (int) $draft->sort_order,
                    'is_published' => true,
                    'avatar_url' => null,
                ],
            ]);
        }

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Create a testimonial (modal AJAX; stay on index).
     */
    public function store(TestimonialStoreRequest $request): JsonResponse|RedirectResponse
    {
        $testimonial = $this->testimonials->create($request);

        return $this->adminSuccess(
            $request,
            'Testimonial',
            'created',
            'admin.testimonials.index',
            [],
            ['testimonial' => ['id' => $testimonial->id]]
        );
    }

    /**
     * Return JSON payload for the edit modal (no dedicated edit page).
     */
    public function edit(Request $request, Testimonial $testimonial): JsonResponse|RedirectResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return response()->json([
                'success' => true,
                'testimonial' => [
                    'id' => $testimonial->id,
                    'quote' => $testimonial->quote,
                    'name' => $testimonial->name,
                    'role' => $testimonial->role,
                    'sort_order' => (int) $testimonial->sort_order,
                    'is_published' => (bool) $testimonial->is_published,
                    'avatar_url' => $testimonial->avatarUrl(),
                    'update_url' => route('admin.testimonials.update', $testimonial),
                ],
            ]);
        }

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Update a testimonial (modal AJAX; stay on index).
     */
    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial): JsonResponse|RedirectResponse
    {
        $testimonial = $this->testimonials->update($request, $testimonial);

        return $this->adminSuccess(
            $request,
            'Testimonial',
            'updated',
            'admin.testimonials.index',
            [],
            ['testimonial' => ['id' => $testimonial->id]]
        );
    }

    /**
     * Delete a testimonial.
     */
    public function destroy(Request $request, Testimonial $testimonial): JsonResponse|RedirectResponse
    {
        $this->testimonials->delete($testimonial);

        return $this->adminSuccess($request, 'Testimonial', 'deleted', 'admin.testimonials.index');
    }
}
