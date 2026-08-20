<?php

namespace App\Http\Requests\Frontend;

use App\Services\ContactRequestService;
use Illuminate\Foundation\Http\FormRequest;

class QuickConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if (app(ContactRequestService::class)->isBotSubmission($this)) {
            return [
                'contact' => ['nullable', 'string', 'max:255'],
            ];
        }

        return [
            'contact' => [
                'required',
                'string',
                'min:5',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $val = trim((string) $value);
                    $isEmail = filter_var($val, FILTER_VALIDATE_EMAIL) !== false;
                    $isPhone = (bool) preg_match('/^[+]?[0-9\s().\-\/]{7,25}$/', $val);

                    if (! $isEmail && ! $isPhone) {
                        $fail('Please enter a valid phone number or email address.');
                    }
                },
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'contact.required' => 'Please enter your phone number or email address.',
            'contact.min' => 'Please enter at least 5 characters.',
            'contact.max' => 'The input may not be longer than 255 characters.',
        ];
    }
}
