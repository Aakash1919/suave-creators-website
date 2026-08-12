<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesCaseStudyFields;
use App\Models\CaseStudy;
use Illuminate\Foundation\Http\FormRequest;

class CaseStudyUpdateRequest extends FormRequest
{
    use ValidatesCaseStudyFields;

    public function authorize(): bool
    {
        return $this->user()?->hasPermission('case-studies.update') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var CaseStudy|null $caseStudy */
        $caseStudy = $this->route('caseStudy');

        return $this->caseStudyRules($caseStudy instanceof CaseStudy ? $caseStudy : null);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->caseStudyMessages();
    }
}
