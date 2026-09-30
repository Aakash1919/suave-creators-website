<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SuaveAgentStartRequest extends FormRequest
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
        if ($this->filled('contact')) {
            return [
                'name' => ['nullable', 'string', 'max:120'],
                'contact' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:40'],
            ];
        }

        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^[+]?[0-9\s().\-\/]{7,40}$/'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Please enter a valid phone number.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
