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

    protected function prepareForValidation(): void
    {
        $message = trim((string) $this->input('message', ''));
        if ($message === '') {
            $service = (string) $this->input('service', '');
            $company = trim((string) $this->input('company', ''));
            $serviceLabel = ContactSupport::formServices()[$service] ?? $service;
            $fallback = 'Free consultation request'
                .($serviceLabel !== '' ? ' for '.$serviceLabel : '')
                .($company !== '' ? ' (Company: '.$company.')' : '')
                .'.';
            $this->merge(['message' => $fallback]);
        } elseif (mb_strlen($message) < 10) {
            $service = (string) $this->input('service', '');
            $serviceLabel = ContactSupport::formServices()[$service] ?? $service;
            $suffix = $serviceLabel !== '' ? ' [Service: '.$serviceLabel.']' : ' [Consultation request]';
            $this->merge(['message' => $message.$suffix]);
        }

        $budget = trim((string) $this->input('budget', ''));
        if ($budget !== '') {
            $service = (string) $this->input('service', '');
            $needLabels = [
                'custom-software' => 'New custom software',
                'custom-crm' => 'CRM or ERP',
                'hire-developers' => 'Hire developers',
                'enterprise-software' => 'Modernize an existing system',
            ];
            $need = $needLabels[$service] ?? (ContactSupport::formServices()[$service] ?? $service);
            $current = trim((string) $this->input('message', ''));
            if (! str_contains($current, 'Budget: '.$budget)) {
                $this->merge(['message' => trim($current.' Need: '.$need.'. Budget: '.$budget.'.')]);
            }
        }
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
                'company' => ['nullable', 'string', 'max:120'],
                'service' => ['nullable', 'string', 'max:120'],
                'message' => ['nullable', 'string', 'max:5000'],
                '_redirect' => ['nullable', 'string', 'max:255'],
            ];
        }

        return [
            'draft_token' => ['nullable', 'uuid'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                $this->filled('budget') ? 'nullable' : 'required',
                'string',
                'max:60',
                'regex:/^\+?[0-9\s\-().]+$/',
            ],
            'company' => ['nullable', 'string', 'max:120'],
            'budget' => ['nullable', 'string', Rule::in([
                'Under $25k',
                '$25–75k',
                '$75–150k',
                '$150k+',
                'Monthly team',
            ])],
            'service' => ['required', 'string', Rule::in(array_keys(ContactSupport::formServices()))],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            '_redirect' => ['nullable', 'string', 'max:255'],
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
            'phone.regex' => 'Phone number may only contain digits and dialing symbols.',
            'service.required' => 'Please select a service.',
            'service.in' => 'Please select a valid service.',
            'message.required' => 'Please tell us what you are trying to fix.',
            'message.min' => 'Please write at least 10 characters about your request.',
            'message.max' => 'Message may not be longer than 5000 characters.',
        ];
    }
}
