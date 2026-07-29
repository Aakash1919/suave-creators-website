<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryStoreRequest;
use App\Http\Requests\Admin\GalleryUpdateRequest;
use App\Models\Image;
use App\Services\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class GalleryController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly GalleryService $gallery,
    ) {}

    /**
     * Gallery index — searchable card grid.
     */
    public function index(Request $request): View
    {
        return view('admin.gallery.index', [
            'images' => $this->gallery->paginate($request),
            'search' => trim((string) $request->input('search', '')),
            'canManage' => $request->user()?->hasPermission('gallery.manage') ?? false,
        ]);
    }

    /**
     * JSON browse endpoint for the blog/testimonial gallery picker.
     */
    public function browse(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            ...$this->gallery->browse($request),
        ]);
    }

    /**
     * Show the upload form.
     */
    public function create(): View
    {
        return view('admin.gallery.form', [
            'image' => $this->gallery->newImage(),
        ]);
    }

    /**
     * Persist a new gallery image.
     */
    public function store(GalleryStoreRequest $request): JsonResponse|RedirectResponse
    {
        $image = $this->gallery->create($request);

        return $this->adminSuccess(
            $request,
            'Image',
            'created',
            'admin.gallery.edit',
            $image,
            ['image' => ['id' => $image->id]]
        );
    }

    /**
     * Show the edit form.
     */
    public function edit(Image $image): View
    {
        return view('admin.gallery.form', [
            'image' => $image,
        ]);
    }

    /**
     * Update gallery metadata and optional replacement file.
     */
    public function update(GalleryUpdateRequest $request, Image $image): JsonResponse|RedirectResponse
    {
        try {
            $image = $this->gallery->update($request, $image);
        } catch (RuntimeException $e) {
            return $this->adminError($request, $e->getMessage());
        }

        return $this->adminSuccess(
            $request,
            'Image',
            'updated',
            'admin.gallery.edit',
            $image,
            ['image' => ['id' => $image->id]]
        );
    }

    /**
     * Delete a gallery image when unused.
     */
    public function destroy(Request $request, Image $image): JsonResponse|RedirectResponse
    {
        try {
            $this->gallery->delete($image);
        } catch (RuntimeException $e) {
            return $this->adminError($request, $e->getMessage());
        }

        return $this->adminSuccess($request, 'Image', 'deleted', 'admin.gallery.index');
    }
}
