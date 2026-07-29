<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesTestimonialFields;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialUpdateRequest extends FormRequest
{
    use ValidatesTestimonialFields;

    public function authorize(): bool
    {
        return $this->user()?->hasPermission('testimonials.manage') ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareTestimonialFields();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->testimonialRules();
    }
}
