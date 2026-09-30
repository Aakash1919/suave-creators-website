<?php

namespace App\Services;

use App\Http\Requests\Admin\BlogCategoryStoreRequest;
use App\Http\Requests\Admin\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryService
{
    /**
     * Empty model for the create modal, with the next sort position.
     */
    public function newCategory(): BlogCategory
    {
        return new BlogCategory([
            'sort_order' => $this->nextSortOrder(),
        ]);
    }

    /**
     * Create a blog category. An empty slug is generated from the name.
     */
    public function create(BlogCategoryStoreRequest $request): BlogCategory
    {
        $data = $request->safe()->only(['name', 'slug', 'sort_order']);

        return BlogCategory::query()->create([
            'name' => $data['name'],
            'slug' => filled($data['slug'] ?? null) ? $data['slug'] : $this->uniqueSlug($data['name']),
            'sort_order' => $data['sort_order'] ?? $this->nextSortOrder(),
        ]);
    }

    /**
     * Update a blog category. Clearing the slug rebuilds it from the name.
     */
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $category): BlogCategory
    {
        $data = $request->safe()->only(['name', 'slug', 'sort_order']);

        $payload = [
            'name' => $data['name'],
            'slug' => filled($data['slug'] ?? null)
                ? $data['slug']
                : $this->uniqueSlug($data['name'], $category->id),
        ];

        if ($data['sort_order'] !== null) {
            $payload['sort_order'] = $data['sort_order'];
        }

        $category->update($payload);

        return $category->refresh();
    }

    /**
     * Build a unique kebab-case slug, appending -2, -3, … when needed.
     */
    public function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::limit($value, 100, '')) ?: 'category';
        $base = Str::limit($base, 110, '');
        $slug = $base;
        $i = 2;

        while (
            BlogCategory::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    /**
     * Next sort position after the current maximum.
     */
    public function nextSortOrder(): int
    {
        return ((int) BlogCategory::query()->max('sort_order')) + 1;
    }
}
