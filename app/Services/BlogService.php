<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
     *
     * @throws ValidationException
     */
    public function create(Request $request): Blog
    {
        $data = $this->validated($request);
        $data['created_by_id'] = $request->user()?->id;
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->storeFeaturedImage($request, $data['slug']);
        }

        return Blog::query()->create($data);
    }

    /**
     * Update a blog post from an admin form request.
     *
     * @throws ValidationException
     */
    public function update(Request $request, Blog $blog): Blog
    {
        $data = $this->validated($request, $blog);
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
     * Validate blog form input and normalize TOC/FAQ JSON fields.
     *
     * @return array<string, mixed>
     *
     * @throws ValidationException
     */
    public function validated(Request $request, ?Blog $blog = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('blogs', 'slug')->ignore($blog?->id)],
            'short_description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'status' => ['required', Rule::in([Blog::STATUS_DRAFT, Blog::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'og_title' => ['nullable', 'string', 'max:95'],
            'og_description' => ['nullable', 'string', 'max:300'],
            'toc_json' => ['nullable', 'string'],
            'faqs_json' => ['nullable', 'string'],
        ]);

        $data['toc'] = $this->decodeJsonList($data['toc_json'] ?? null);
        $data['faqs'] = $this->decodeJsonList($data['faqs_json'] ?? null);
        unset($data['toc_json'], $data['faqs_json'], $data['featured_image']);

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
     * Decode a JSON array string from the form, or null when empty/invalid.
     *
     * @return array<int, mixed>|null
     */
    public function decodeJsonList(?string $json): ?array
    {
        if ($json === null || trim($json) === '') {
            return null;
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : null;
    }
}
