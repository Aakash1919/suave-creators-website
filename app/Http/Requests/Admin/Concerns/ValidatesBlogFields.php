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

        $optionalUrl = static function (string $attribute, mixed $value, \Closure $fail): void {
            $url = trim((string) $value);
            if ($url !== '' && filter_var($url, FILTER_VALIDATE_URL) === false) {
                $fail('Enter a valid URL.');
            }
        };

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('blogs', 'slug')->ignore($blog?->id)],
            'short_description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'status' => ['required', Rule::in([Blog::STATUS_DRAFT, Blog::STATUS_PUBLISHED])],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'featured_image_position' => ['nullable', 'string', Rule::in(['after_first_p', 'top', 'bottom', 'manual', 'hide'])],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'og_title' => ['nullable', 'string', 'max:60'],
            'og_description' => ['nullable', 'string', 'max:160'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['required', 'string', 'max:500', $requiredText('Each FAQ needs a question.')],
            'faqs.*.answer' => ['required', 'string', 'max:5000', $requiredText('Each FAQ needs an answer.')],
            'tags' => ['nullable', 'string', 'max:500'],
            'keywords' => ['nullable', 'string', 'max:2000'],
            'about' => ['nullable', 'array'],
            'about.*.name' => ['required', 'string', 'max:255', $requiredText('Each about entry needs a name.')],
            'about.*.same_as' => ['nullable', 'string', 'max:500', $optionalUrl],
            'mentions' => ['nullable', 'array'],
            'mentions.*.type' => ['required', Rule::in(['Organization', 'Service'])],
            'mentions.*.name' => ['required', 'string', 'max:255', $requiredText('Each mention needs a name.')],
            'mentions.*.url' => ['nullable', 'string', 'max:500', $optionalUrl],
            'mentions.*.same_as' => ['nullable', 'string', 'max:500', $optionalUrl],
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
            'about.*.name.required' => 'Each about entry needs a name.',
            'mentions.*.name.required' => 'Each mention needs a name.',
            'mentions.*.type.required' => 'Each mention needs a type.',
        ];
    }
}
