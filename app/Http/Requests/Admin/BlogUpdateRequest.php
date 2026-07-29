<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesBlogFields;
use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
{
    use ValidatesBlogFields;

    public function authorize(): bool
    {
        return $this->user()?->hasPermission('blogs.update') ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareBlogFields();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var Blog|null $blog */
        $blog = $this->route('blog');

        return $this->blogRules($blog instanceof Blog ? $blog : null);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->blogMessages();
    }
}
