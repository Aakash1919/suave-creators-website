<?php

namespace App\Http\Requests\Frontend;

use App\Services\ContactRequestService;
use App\Support\Frontend\ContactSupport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactStoreRequest extends FormRequest
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
        // Bots must pass validation so the controller can return a silent success.
        if (app(ContactRequestService::class)->isBotSubmission($this)) {
            return [
                'draft_token' => ['nullable', 'uuid'],
                'name' => ['nullable', 'string', 'max:120'],
                'email' => ['nullable', 'email', 'max:255'],
                'phone' => ['nullable', 'string', 'max:60'],
                'service' => ['nullable', 'string', 'max:120'],
                'message' => ['nullable', 'string', 'max:5000'],
            ];
        }

        return [
            'draft_token' => ['nullable', 'uuid'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:60'],
            'service' => ['required', 'string', Rule::in(array_keys(ContactSupport::formServices()))],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.max' => 'Full name may not be longer than 120 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email may not be longer than 255 characters.',
            'phone.required' => 'Please enter your phone number.',
            'phone.max' => 'Phone number may not be longer than 60 characters.',
            'service.required' => 'Please select a service.',
            'service.in' => 'Please select a valid service.',
            'message.required' => 'Please tell us what you are trying to fix.',
            'message.min' => 'Please write at least 10 characters about your request.',
            'message.max' => 'Message may not be longer than 5000 characters.',
        ];
    }
}
