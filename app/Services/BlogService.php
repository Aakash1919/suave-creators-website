<?php

namespace App\Services;

use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogService
{
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
            $data['featured_image'] = $this->storeFeaturedImage($request, $data['slug']);
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
            $this->deleteFeaturedImage($blog->featured_image);
            $data['featured_image'] = $this->storeFeaturedImage($request, $data['slug']);
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
     * Store the featured image on the public disk under blogs/{slug}.{ext}.
     */
    public function storeFeaturedImage(Request $request, string $slug): string
    {
        $file = $request->file('featured_image');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';

        return $file->storeAs('blogs', $slug.'.'.$ext, 'public');
    }

    /**
     * Delete a local featured image path; skip remote http(s) URLs.
     */
    public function deleteFeaturedImage(?string $path): void
    {
        if (! is_string($path) || $path === '') {
            return;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        Storage::disk('public')->delete($path);
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
