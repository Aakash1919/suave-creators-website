<?php

namespace App\Http\Requests\Admin\Concerns;

use App\Models\Blog;
use Illuminate\Validation\Rule;

trait ValidatesBlogFields
{
    /**
     * @return array<string, mixed>
     */
    protected function blogRules(?Blog $blog = null): array
    {
        $requiredText = static function (string $message): \Closure {
            return static function (string $attribute, mixed $value, \Closure $fail) use ($message): void {
                if (trim((string) $value) === '') {
                    $fail($message);
                }
            };
        };

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('blogs', 'slug')->ignore($blog?->id)],
            'short_description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'status' => ['required', Rule::in([Blog::STATUS_DRAFT, Blog::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'gallery_image_id' => ['nullable', 'integer', 'exists:images,id'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'og_title' => ['nullable', 'string', 'max:60'],
            'og_description' => ['nullable', 'string', 'max:160'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['required', 'string', 'max:500', $requiredText('Each FAQ needs a question.')],
            'faqs.*.answer' => ['required', 'string', 'max:5000', $requiredText('Each FAQ needs an answer.')],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function blogMessages(): array
    {
        return [
            'faqs.*.question.required' => 'Each FAQ needs a question.',
            'faqs.*.answer.required' => 'Each FAQ needs an answer.',
        ];
    }

    protected function prepareBlogFields(): void
    {
        if ($this->has('remove_featured_image')) {
            $this->merge([
                'remove_featured_image' => $this->boolean('remove_featured_image'),
            ]);
        }

        if ($this->filled('gallery_image_id')) {
            $this->merge([
                'gallery_image_id' => (int) $this->input('gallery_image_id'),
            ]);
        } else {
            $this->merge(['gallery_image_id' => null]);
        }
    }
}
