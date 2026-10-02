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

        $composed = ContactSupport::composeInquiryMessage(
            trim((string) $this->input('message', '')),
            $this->all(),
        );
        if ($composed !== trim((string) $this->input('message', ''))) {
            $this->merge(['message' => $composed]);
        }
    }

    /**
     * @return list<string>
     */
    private function allowedServices(): array
    {
        return match ((string) $this->input('inquiry')) {
            'project-estimate' => array_keys(ContactSupport::projectEstimateServices()),
            'hire-developers' => ['hire-developers'],
            default => array_keys(ContactSupport::formServices()),
        };
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
                $this->filled('budget') || $this->filled('inquiry') ? 'nullable' : 'required',
                'string',
                'max:60',
                'regex:/^\+?[0-9\s\-().]+$/',
            ],
            'company' => ['nullable', 'string', 'max:120'],
            'inquiry' => ['nullable', 'string', Rule::in(['project-estimate', 'hire-developers'])],
            'expertise' => [
                $this->input('inquiry') === 'hire-developers' ? 'required' : 'nullable',
                'string',
                'max:120',
                Rule::in(ContactSupport::hireExpertiseOptions()),
            ],
            'support_type' => [
                $this->input('inquiry') === 'hire-developers' ? 'required' : 'nullable',
                'string',
                'max:120',
                Rule::in(ContactSupport::hireSupportOptions()),
            ],
            'start_when' => ['nullable', 'string', 'max:120', Rule::in(ContactSupport::hireStartOptions())],
            'budget' => ['nullable', 'string', Rule::in(ContactSupport::projectBudgets())],
            'service' => ['required', 'string', Rule::in($this->allowedServices())],
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
            'inquiry.in' => 'Please choose a valid request type.',
            'expertise.required' => 'Please select the expertise you need.',
            'expertise.in' => 'Please select a valid expertise.',
            'support_type.required' => 'Please select the kind of support you need.',
            'support_type.in' => 'Please select a valid support type.',
            'start_when.in' => 'Please select a valid start time.',
            'budget.in' => 'Please select a valid budget range.',
            'message.required' => 'Please tell us what you are trying to fix.',
            'message.min' => 'Please write at least 10 characters about your request.',
            'message.max' => 'Message may not be longer than 5000 characters.',
        ];
    }
}
