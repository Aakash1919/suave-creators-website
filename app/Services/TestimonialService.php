<?php

namespace App\Services;

use App\Http\Requests\Admin\TestimonialStoreRequest;
use App\Http\Requests\Admin\TestimonialUpdateRequest;
use App\Models\Image;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class TestimonialService
{
    public const CACHE_KEY = 'frontend.testimonials';

    public function __construct(
        protected ImageVariantService $images,
    ) {}

    /**
     * Empty model for the create form.
     */
    public function newTestimonial(): Testimonial
    {
        return new Testimonial([
            'is_published' => true,
            'sort_order' => ((int) Testimonial::query()->max('sort_order')) + 1,
        ]);
    }

    /**
     * Published testimonials for marketing pages (forever cache; forgotten on write).
     *
     * @return list<array{quote: string, name: string, role: string, initials: string, avatar: string, avatarAlt: string}>
     */
    public function cachedForFrontend(): array
    {
        /** @var list<array{quote: string, name: string, role: string, initials: string, avatar: string, avatarAlt: string}> */
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return Testimonial::query()
                ->published()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (Testimonial $testimonial): array => $testimonial->toFrontendArray())
                ->values()
                ->all();
        });
    }

    /**
     * Drop the frontend testimonials cache after any mutation.
     */
    public function forgetFrontendCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Create a testimonial and invalidate the frontend cache.
     */
    public function create(TestimonialStoreRequest $request): Testimonial
    {
        $data = $request->safe()->except(['avatar', 'remove_avatar', 'gallery_image_id']);

        $this->applyGallerySelection($data, $request->integer('gallery_image_id') ?: null);

        $testimonial = Testimonial::query()->create($data);
        $this->forgetFrontendCache();

        return $testimonial;
    }

    /**
     * Update a testimonial and invalidate the frontend cache.
     */
    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial): Testimonial
    {
        $data = $request->safe()->except(['avatar', 'remove_avatar', 'gallery_image_id']);

        if ($request->boolean('remove_avatar')) {
            $this->deleteOwnedPaths(
                $testimonial->avatar,
                $testimonial->small_thumb_avatar,
                $testimonial->medium_thumb_avatar,
            );
            $data['avatar'] = null;
            $data['small_thumb_avatar'] = null;
            $data['medium_thumb_avatar'] = null;
        } elseif ($request->filled('gallery_image_id')) {
            $this->deleteOwnedPaths(
                $testimonial->avatar,
                $testimonial->small_thumb_avatar,
                $testimonial->medium_thumb_avatar,
            );
            $this->applyGallerySelection($data, $request->integer('gallery_image_id'));
        }

        $testimonial->update($data);
        $this->forgetFrontendCache();

        return $testimonial->refresh();
    }

    /**
     * Delete a testimonial and the frontend cache (gallery files are left intact).
     */
    public function delete(Testimonial $testimonial): void
    {
        $this->deleteOwnedPaths(
            $testimonial->avatar,
            $testimonial->small_thumb_avatar,
            $testimonial->medium_thumb_avatar,
        );
        $testimonial->delete();
        $this->forgetFrontendCache();
    }

    /**
     * Copy gallery image paths onto the testimonial payload.
     *
     * @param  array<string, mixed>  $data
     */
    protected function applyGallerySelection(array &$data, ?int $galleryImageId): void
    {
        if (! $galleryImageId) {
            return;
        }

        $image = Image::query()->find($galleryImageId);
        if ($image === null) {
            return;
        }

        $data['avatar'] = $image->path;
        $data['small_thumb_avatar'] = $image->small_thumb_path;
        $data['medium_thumb_avatar'] = $image->medium_thumb_path;
    }

    /**
     * Delete legacy owned disk files only (never gallery `images/` paths).
     */
    protected function deleteOwnedPaths(?string ...$paths): void
    {
        foreach ($paths as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }

            $normalized = ltrim(str_replace('\\', '/', $path), '/');
            if (str_starts_with($normalized, 'blogs/') || str_starts_with($normalized, 'testimonials/')) {
                $this->images->deletePaths($normalized);
            }
        }
    }
}
