<?php

namespace App\Services;

use App\Http\Requests\Admin\GalleryStoreRequest;
use App\Http\Requests\Admin\GalleryUpdateRequest;
use App\Models\Blog;
use App\Models\Image;
use App\Models\Testimonial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;

class GalleryService
{
    public function __construct(
        protected ImageVariantService $images,
    ) {}

    /**
     * Empty model for the create form.
     */
    public function newImage(): Image
    {
        return new Image;
    }

    /**
     * Paginated gallery listing for the admin index (optional title search).
     *
     * @return LengthAwarePaginator<int, Image>
     */
    public function paginate(Request $request, int $perPage = 24): LengthAwarePaginator
    {
        $search = trim((string) $request->input('search', ''));

        return Image::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('title', 'like', '%'.$search.'%')
                        ->orWhere('alt_text', 'like', '%'.$search.'%');
                });
            })
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Paginated JSON-friendly browse payload for the gallery picker.
     *
     * @return array{data: list<array<string, mixed>>, meta: array{current_page: int, last_page: int, per_page: int, total: int}}
     */
    public function browse(Request $request, int $perPage = 24): array
    {
        $paginator = $this->paginate($request, $perPage);

        $data = $paginator->getCollection()
            ->map(fn (Image $image): array => $this->toPickerArray($image))
            ->values()
            ->all();

        return [
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
    }

    /**
     * @return array{id: int, title: string, alt_text: string, path: string, small_thumb_path: ?string, medium_thumb_path: ?string, url: ?string, small_thumb_url: ?string, medium_thumb_url: ?string}
     */
    public function toPickerArray(Image $image): array
    {
        return [
            'id' => $image->id,
            'title' => (string) ($image->title ?? ''),
            'alt_text' => (string) ($image->alt_text ?? ''),
            'path' => (string) $image->path,
            'small_thumb_path' => $image->small_thumb_path,
            'medium_thumb_path' => $image->medium_thumb_path,
            'url' => $image->url(),
            'small_thumb_url' => $image->smallThumbUrl(),
            'medium_thumb_url' => $image->mediumThumbUrl(),
        ];
    }

    /**
     * Upload a new gallery image with original + thumb variants.
     */
    public function create(GalleryStoreRequest $request): Image
    {
        $validated = $request->validated();
        $file = $request->file('image');
        $basename = Str::lower(Str::random(16));
        $variants = $this->images->storeWithVariants($file, 'images', $basename);

        return Image::query()->create([
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'path' => $variants['original'],
            'small_thumb_path' => $variants['small'],
            'medium_thumb_path' => $variants['medium'],
            'created_by_id' => $request->user()?->id,
        ]);
    }

    /**
     * Update gallery metadata and optionally replace the file.
     */
    public function update(GalleryUpdateRequest $request, Image $image): Image
    {
        $validated = $request->validated();
        $data = [
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($this->isReferenced($image)) {
                throw new RuntimeException(
                    'This image is used by a blog or testimonial. Remove those references before replacing the file.'
                );
            }

            $this->images->deletePaths(
                $image->path,
                $image->small_thumb_path,
                $image->medium_thumb_path,
            );

            $file = $request->file('image');
            $basename = pathinfo($image->path, PATHINFO_FILENAME) ?: Str::lower(Str::random(16));
            $variants = $this->images->storeWithVariants($file, 'images', $basename);
            $data['path'] = $variants['original'];
            $data['small_thumb_path'] = $variants['small'];
            $data['medium_thumb_path'] = $variants['medium'];
        }

        $image->update($data);

        return $image->refresh();
    }

    /**
     * Delete a gallery image when it is not referenced by blogs or testimonials.
     *
     * @throws RuntimeException
     */
    public function delete(Image $image): void
    {
        if ($this->isReferenced($image)) {
            throw new RuntimeException(
                'This image is used by a blog or testimonial. Remove those references before deleting.'
            );
        }

        $this->images->deletePaths(
            $image->path,
            $image->small_thumb_path,
            $image->medium_thumb_path,
        );

        $image->delete();
    }

    /**
     * Whether any blog or testimonial still points at this gallery original path.
     */
    public function isReferenced(Image $image): bool
    {
        $path = (string) $image->path;

        if ($path === '') {
            return false;
        }

        return Blog::query()->where('featured_image', $path)->exists()
            || Testimonial::query()->where('avatar', $path)->exists();
    }
}
