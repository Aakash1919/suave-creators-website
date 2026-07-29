<?php

namespace App\Services;

use App\Http\Requests\Admin\TestimonialStoreRequest;
use App\Http\Requests\Admin\TestimonialUpdateRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialService
{
    public const CACHE_KEY = 'frontend.testimonials';

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
        $data = $request->safe()->except(['avatar', 'remove_avatar']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->storeAvatar($request);
        }

        $testimonial = Testimonial::query()->create($data);
        $this->forgetFrontendCache();

        return $testimonial;
    }

    /**
     * Update a testimonial and invalidate the frontend cache.
     */
    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial): Testimonial
    {
        $data = $request->safe()->except(['avatar', 'remove_avatar']);

        if ($request->hasFile('avatar')) {
            $this->deleteStoredAvatar($testimonial->avatar);
            $data['avatar'] = $this->storeAvatar($request, $testimonial->id);
        }

        if ($request->boolean('remove_avatar')) {
            $this->deleteStoredAvatar($testimonial->avatar);
            $data['avatar'] = null;
        }

        $testimonial->update($data);
        $this->forgetFrontendCache();

        return $testimonial->refresh();
    }

    /**
     * Delete a testimonial, its stored avatar, and the frontend cache.
     */
    public function delete(Testimonial $testimonial): void
    {
        $this->deleteStoredAvatar($testimonial->avatar);
        $testimonial->delete();
        $this->forgetFrontendCache();
    }

    /**
     * Store an uploaded avatar under testimonials/ on the public disk.
     */
    public function storeAvatar(Request $request, ?int $id = null): string
    {
        $file = $request->file('avatar');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $basename = $id ? 'testimonial-'.$id : 'testimonial-'.Str::lower(Str::random(8));

        return $file->storeAs('testimonials', $basename.'.'.$ext, 'public');
    }

    /**
     * Delete a stored avatar; skip public assets/ and remote URLs.
     */
    public function deleteStoredAvatar(?string $path): void
    {
        if (! is_string($path) || $path === '') {
            return;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (
            str_starts_with($normalized, 'http://')
            || str_starts_with($normalized, 'https://')
            || str_starts_with($normalized, 'assets/')
            || str_starts_with($normalized, 'storage/')
        ) {
            return;
        }

        Storage::disk('public')->delete($normalized);
    }
}
