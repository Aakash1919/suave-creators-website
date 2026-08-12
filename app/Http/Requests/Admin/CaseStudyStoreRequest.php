<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesCaseStudyFields;
use Illuminate\Foundation\Http\FormRequest;

class CaseStudyStoreRequest extends FormRequest
{
    use ValidatesCaseStudyFields;

    public function authorize(): bool
    {
        return $this->user()?->hasPermission('case-studies.create') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->caseStudyRules();
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->caseStudyMessages();
    }
}
