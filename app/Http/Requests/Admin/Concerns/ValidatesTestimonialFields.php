<?php

namespace App\Http\Requests\Admin\Concerns;

trait ValidatesTestimonialFields
{
    /**
     * @return array<string, mixed>
     */
    protected function testimonialRules(): array
    {
        return [
            'quote' => ['required', 'string', 'max:2000'],
            'name' => ['required', 'string', 'max:120'],
            'role' => ['required', 'string', 'max:160'],
            'gallery_image_id' => ['nullable', 'integer', 'exists:images,id'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_published' => ['nullable', 'boolean'],
            'remove_avatar' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareTestimonialFields(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name', '')),
            'role' => trim((string) $this->input('role', '')),
            'quote' => trim((string) $this->input('quote', '')),
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_published' => $this->boolean('is_published'),
            'remove_avatar' => $this->boolean('remove_avatar'),
            'gallery_image_id' => $this->filled('gallery_image_id') ? (int) $this->input('gallery_image_id') : null,
        ]);
    }
}
