<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogPublishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('blogs.update') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
