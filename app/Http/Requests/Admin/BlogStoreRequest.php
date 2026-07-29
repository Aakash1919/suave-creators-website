<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesBlogFields;
use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    use ValidatesBlogFields;

    public function authorize(): bool
    {
        return $this->user()?->hasPermission('blogs.create') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->blogRules();
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->blogMessages();
    }
}
