<?php

namespace App\Services;

use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Image;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BlogService
{
    public function __construct(
        protected ImageVariantService $images,
    ) {}

    /**
     * Categories for the admin blog form select.
     *
     * @return Collection<int, BlogCategory>
     */
    public function categories(): Collection
    {
        return BlogCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Empty draft model for the create form.
     */
    public function newDraft(): Blog
    {
        return new Blog([
            'status' => Blog::STATUS_DRAFT,
        ]);
    }

    /**
     * Create a blog post from an admin form request.
     */
    public function create(BlogStoreRequest $request): Blog
    {
        $data = $this->attributesFromValidated($request->validated());
        $data['created_by_id'] = $request->user()?->id;
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title']);

        $this->applyGallerySelection($data, $request->integer('gallery_image_id') ?: null);

        return Blog::query()->create($data);
    }

    /**
     * Persist a draft from a trusted internal payload (e.g. AI generation).
     *
     * @param  array<string, mixed>  $data
     */
    public function createDraft(array $data): Blog
    {
        $data['status'] = Blog::STATUS_DRAFT;
        $data['published_at'] = null;

        if (empty($data['slug']) && ! empty($data['title'])) {
            $data['slug'] = $this->uniqueSlug((string) $data['title']);
        }

        return Blog::query()->create($data);
    }

    /**
     * Update a blog post from an admin form request.
     */
    public function update(BlogUpdateRequest $request, Blog $blog): Blog
    {
        $data = $this->attributesFromValidated($request->validated());
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title'], $blog->id);

        if ($request->boolean('remove_featured_image')) {
            $this->deleteOwnedPaths(
                $blog->featured_image,
                $blog->small_thumb_image,
                $blog->medium_thumb_image,
            );
            $data['featured_image'] = null;
            $data['small_thumb_image'] = null;
            $data['medium_thumb_image'] = null;
        } elseif ($request->filled('gallery_image_id')) {
            $this->deleteOwnedPaths(
                $blog->featured_image,
                $blog->small_thumb_image,
                $blog->medium_thumb_image,
            );
            $this->applyGallerySelection($data, $request->integer('gallery_image_id'));
        }

        $blog->update($data);

        return $blog->refresh();
    }

    /**
     * Soft-delete a blog post.
     */
    public function delete(Blog $blog): void
    {
        $blog->delete();
    }

    /**
     * Normalize validated blog form data for persistence.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function attributesFromValidated(array $data): array
    {
        $data['faqs'] = $this->normalizeFaqItems($data['faqs'] ?? null);
        unset($data['featured_image'], $data['gallery_image_id'], $data['remove_featured_image']);

        if (($data['status'] ?? null) === Blog::STATUS_PUBLISHED && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    /**
     * Copy gallery image paths onto the blog payload.
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

        $data['featured_image'] = $image->path;
        $data['small_thumb_image'] = $image->small_thumb_path;
        $data['medium_thumb_image'] = $image->medium_thumb_path;
    }

    /**
     * Delete legacy owned blog/testimonial disk files only (never gallery `images/` paths).
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

    /**
     * Build a unique kebab-case slug, appending -2, -3, … when needed.
     */
    public function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::limit($value, 140, '')) ?: 'post';
        $slug = $base;
        $i = 2;

        while (
            Blog::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    /**
     * Normalize TOC repeater rows into [{anchor_id, label}, …].
     *
     * @return list<array{anchor_id: string, label: string}>|null
     */
    public function normalizeTocItems(mixed $items): ?array
    {
        if (! is_array($items) || $items === []) {
            return null;
        }

        $out = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $label = trim((string) ($item['label'] ?? ''));
            $anchor = trim((string) ($item['anchor_id'] ?? $item['id'] ?? ''));

            $out[] = [
                'anchor_id' => $anchor,
                'label' => $label,
            ];
        }

        return $out === [] ? null : array_values($out);
    }

    /**
     * Normalize FAQ repeater rows into [{question, answer}, …].
     *
     * @return list<array{question: string, answer: string}>|null
     */
    public function normalizeFaqItems(mixed $items): ?array
    {
        if (! is_array($items) || $items === []) {
            return null;
        }

        $out = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $out[] = [
                'question' => trim((string) ($item['question'] ?? '')),
                'answer' => trim((string) ($item['answer'] ?? '')),
            ];
        }

        return $out === [] ? null : array_values($out);
    }
}
