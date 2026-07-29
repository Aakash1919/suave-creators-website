<?php

namespace App\Services;

use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
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

        if ($request->hasFile('featured_image')) {
            $this->applyFeaturedImageVariants($data, $request, $data['slug']);
        }

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

        if ($request->hasFile('featured_image')) {
            $this->deleteFeaturedImageVariants($blog);
            $this->applyFeaturedImageVariants($data, $request, $data['slug']);
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
        unset($data['featured_image']);

        if (($data['status'] ?? null) === Blog::STATUS_PUBLISHED && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
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
     * Store original + medium thumb under blogs/{slug}*.{ext}.
     *
     * @param  array<string, mixed>  $data
     */
    protected function applyFeaturedImageVariants(array &$data, Request $request, string $slug): void
    {
        $variants = $this->images->storeWithVariants(
            $request->file('featured_image'),
            'blogs',
            $slug
        );

        $data['featured_image'] = $variants['original'];
        $data['medium_thumb_image'] = $variants['medium'];
    }

    /**
     * Delete owned blog featured image variants from the public disk.
     */
    protected function deleteFeaturedImageVariants(Blog $blog): void
    {
        $this->images->deletePaths(
            $blog->featured_image,
            $blog->medium_thumb_image,
            $this->images->legacySmallThumbPath($blog->featured_image),
            $this->images->legacyMediumThumbPath($blog->featured_image),
        );
    }

    /**
     * Generate (or refresh) the medium thumb for an existing featured image.
     *
     * @throws \RuntimeException
     */
    public function regenerateMediumThumb(Blog $blog): string
    {
        $original = is_string($blog->featured_image) ? $blog->featured_image : '';

        if ($original === '') {
            throw new \RuntimeException('Blog has no featured image.');
        }

        $this->images->deletePaths(
            $blog->medium_thumb_image,
            $this->images->legacySmallThumbPath($original),
            $this->images->legacyMediumThumbPath($original),
        );

        $medium = $this->images->generateMediumFromStored($original);
        $blog->forceFill(['medium_thumb_image' => $medium])->save();

        return $medium;
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
