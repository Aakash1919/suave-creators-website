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
     * Validate blog form input and normalize FAQ repeater fields.
     * TOC admin UI is disabled for now (unused on frontend single-blog) — existing `toc` is left unchanged.
     *
     * @return array<string, mixed>
     *
     * @throws ValidationException
     */
    public function validated(Request $request, ?Blog $blog = null): array
    {
        $requiredText = static function (string $message): \Closure {
            return static function (string $attribute, mixed $value, \Closure $fail) use ($message): void {
                if (trim((string) $value) === '') {
                    $fail($message);
                }
            };
        };

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
            // TOC disabled until frontend single-blog uses it:
            // 'toc' => ['nullable', 'array'],
            // 'toc.*.label' => ['required', 'string', 'max:255', $requiredText('Each TOC item needs a label.')],
            // 'toc.*.anchor_id' => ['required', 'string', 'max:160', $requiredText('Each TOC item needs an anchor ID.'), 'regex:/^[A-Za-z0-9_-]+$/'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['required', 'string', 'max:500', $requiredText('Each FAQ needs a question.')],
            'faqs.*.answer' => ['required', 'string', 'max:5000', $requiredText('Each FAQ needs an answer.')],
        ], [
            // 'toc.*.label.required' => 'Each TOC item needs a label.',
            // 'toc.*.anchor_id.required' => 'Each TOC item needs an anchor ID.',
            // 'toc.*.anchor_id.regex' => 'TOC anchor IDs may only contain letters, numbers, hyphens, and underscores.',
            'faqs.*.question.required' => 'Each FAQ needs a question.',
            'faqs.*.answer.required' => 'Each FAQ needs an answer.',
        ]);

        // $data['toc'] = $this->normalizeTocItems($data['toc'] ?? null);
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
     * @param  mixed  $items
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
     * @param  mixed  $items
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
