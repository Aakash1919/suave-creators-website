<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesBlogCategoryFields;
use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryUpdateRequest extends FormRequest
{
    use ValidatesBlogCategoryFields;

    public function authorize(): bool
    {
        return $this->user()?->hasPermission('blog-categories.update') ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareBlogCategoryFields();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->blogCategoryRules();
    }
}
