<?php

namespace App\Http\Requests\Frontend;

use App\Support\Frontend\ContactSupport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactDraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $emptyToNull = [];
        foreach (['draft_token', 'name', 'email', 'phone', 'service', 'message'] as $field) {
            if ($this->exists($field) && trim((string) $this->input($field)) === '') {
                $emptyToNull[$field] = null;
            }
        }

        if ($emptyToNull !== []) {
            $this->merge($emptyToNull);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'draft_token' => ['nullable', 'uuid'],
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:60'],
            'service' => ['nullable', 'string', Rule::in(array_keys(ContactSupport::formServices()))],
            'message' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
