<?php

namespace App\Http\Requests\Admin\Concerns;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait ValidatesBlogCategoryFields
{
    /**
     * @return array<string, mixed>
     */
    protected function blogCategoryRules(): array
    {
        $category = $this->route('blogCategory');
        $ignoreId = $category instanceof BlogCategory ? $category->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('blog_categories', 'name')->ignore($ignoreId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:120',
                Rule::unique('blog_categories', 'slug')->ignore($ignoreId),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    protected function prepareBlogCategoryFields(): void
    {
        $slugInput = trim((string) $this->input('slug', ''));
        $slug = $slugInput === '' ? null : Str::slug(Str::limit($slugInput, 120, ''));

        $this->merge([
            'name' => trim((string) $this->input('name', '')),
            'slug' => $slug === '' ? null : $slug,
            'sort_order' => $this->filled('sort_order') ? (int) $this->input('sort_order') : null,
        ]);
    }
}
