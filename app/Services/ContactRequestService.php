<?php

namespace App\Services;

use App\Http\Requests\Frontend\ContactDraftRequest;
use App\Http\Requests\Frontend\ContactStoreRequest;
use App\Http\Requests\Frontend\QuickConsultationRequest;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactRequestService
{
    public const MIN_SUBMIT_SECONDS = 3;

    public const FLOOD_WINDOW_MINUTES = 15;

    public const MAX_RECENT_FINAL_SUBMISSIONS_PER_IP = 6;

    public const MAX_RECENT_DRAFTS_PER_IP = 12;

    public const DUPLICATE_WINDOW_MINUTES = 60;

    public const SUCCESS_MESSAGE = 'The request has been sent successfully.';

    /**
     * Whether the submission looks like a bot (honeypot filled or form submitted too fast).
     */
    public function isBotSubmission(Request $request): bool
    {
        if ($this->isHoneypotFilled($request)) {
            return true;
        }

        $startedAt = (int) $request->input('form_started_at', 0);
        if ($startedAt <= 0) {
            return true;
        }

        $elapsed = time() - $startedAt;

        return $elapsed < self::MIN_SUBMIT_SECONDS
            || $elapsed > 86_400
            || $this->hasTooManyRecentFinalSubmissions($request);
    }

    /**
     * Whether the honeypot field was filled (bot).
     */
    public function isHoneypotFilled(Request $request): bool
    {
        return trim((string) $request->input('website', '')) !== '';
    }

    /**
     * Persist a legitimate contact request (validation happens in ContactStoreRequest).
     */
    public function store(ContactStoreRequest $request): ContactRequest
    {
        $data = $request->validated();
        $token = $this->nullableString($data['draft_token'] ?? null);
        unset($data['draft_token']);

        $attributes = [
            ...$data,
            'status' => ContactRequest::STATUS_NEW,
            'ip_address' => $request->ip(),
            'user_agent' => $this->userAgent($request),
        ];

        $draft = $this->findDraft($token);
        if ($draft !== null) {
            $draft->fill($attributes)->save();

            return $draft->fresh();
        }

        $duplicate = $this->findRecentDuplicate($attributes, $request, [
            ContactRequest::STATUS_NEW,
            ContactRequest::STATUS_READ,
        ]);
        if ($duplicate !== null) {
            return $duplicate->fresh();
        }

        $attributes['draft_token'] = $token;

        return ContactRequest::query()->create($attributes);
    }

    /**
     * Create or update an incomplete contact row as the visitor fills fields.
     */
    public function saveDraft(ContactDraftRequest $request): ?ContactRequest
    {
        if ($this->isHoneypotFilled($request)) {
            return null;
        }

        $data = $request->validated();
        $token = $this->nullableString($data['draft_token'] ?? null) ?? (string) Str::uuid();
        unset($data['draft_token']);

        $attributes = $this->draftFieldAttributes($data);
        if ($this->isEmptyDraft($attributes)) {
            return null;
        }

        $existing = ContactRequest::query()->where('draft_token', $token)->first();
        if ($existing !== null) {
            if (! $existing->isDraft()) {
                return $existing;
            }

            $existing->fill([
                ...$attributes,
                'ip_address' => $request->ip(),
                'user_agent' => $this->userAgent($request),
            ])->save();

            return $existing->fresh();
        }

        if ($this->hasTooManyRecentDrafts($request)) {
            return null;
        }

        $duplicate = $this->findRecentDuplicate($attributes, $request, [
            ContactRequest::STATUS_DRAFT,
        ]);
        if ($duplicate !== null) {
            return $duplicate->fresh();
        }

        return ContactRequest::query()->create([
            ...$attributes,
            'draft_token' => $token,
            'status' => ContactRequest::STATUS_DRAFT,
            'ip_address' => $request->ip(),
            'user_agent' => $this->userAgent($request),
        ]);
    }

    /**
     * Persist an inline quick consultation request.
     */
    public function storeQuickConsultation(QuickConsultationRequest $request): ContactRequest
    {
        $data = $request->validated();
        $contact = trim((string) ($data['contact'] ?? ''));
        $token = $this->nullableString($data['draft_token'] ?? null);
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL) !== false;

        $attributes = [
            'name' => 'Consultation Lead',
            'email' => $isEmail ? $contact : 'consultation-lead@suavecreators.com',
            'phone' => $isEmail ? '' : Str::limit($contact, 60, ''),
            'service' => 'Free Consultation',
            'message' => 'Free consultation requested via inline form for: '.$contact,
            'status' => ContactRequest::STATUS_NEW,
            'ip_address' => $request->ip(),
            'user_agent' => $this->userAgent($request),
        ];

        $draft = $this->findDraft($token);
        if ($draft !== null) {
            $draft->fill($attributes)->save();

            return $draft->fresh();
        }

        $duplicate = $this->findRecentDuplicate($attributes, $request, [
            ContactRequest::STATUS_NEW,
            ContactRequest::STATUS_READ,
        ]);
        if ($duplicate !== null) {
            return $duplicate->fresh();
        }

        $attributes['draft_token'] = $token;

        return ContactRequest::query()->create($attributes);
    }

    /**
     * Mark a contact request as read when it is still new.
     */
    public function markRead(ContactRequest $contact): ContactRequest
    {
        $contact->markRead();

        return $contact->fresh();
    }

    /**
     * Archive a contact request.
     */
    public function archive(ContactRequest $contact): ContactRequest
    {
        $contact->markArchived();

        return $contact->fresh();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{name: ?string, email: ?string, phone: ?string, service: ?string, message: ?string}
     */
    private function draftFieldAttributes(array $data): array
    {
        return [
            'name' => $this->nullableString($data['name'] ?? null),
            'email' => $this->nullableString($data['email'] ?? null),
            'phone' => $this->nullableString($data['phone'] ?? null),
            'service' => $this->nullableString($data['service'] ?? null),
            'message' => $this->nullableString($data['message'] ?? null),
        ];
    }

    /**
     * @param  array{name: ?string, email: ?string, phone: ?string, service: ?string, message: ?string}  $attributes
     */
    private function isEmptyDraft(array $attributes): bool
    {
        return $attributes['name'] === null
            && $attributes['email'] === null
            && $attributes['phone'] === null
            && $attributes['service'] === null
            && $attributes['message'] === null;
    }

    private function findDraft(?string $token): ?ContactRequest
    {
        if ($token === null) {
            return null;
        }

        return ContactRequest::query()
            ->where('draft_token', $token)
            ->where('status', ContactRequest::STATUS_DRAFT)
            ->first();
    }

    /**
     * @param  array<int, string>  $statuses
     * @param  array<string, mixed>  $attributes
     */
    private function findRecentDuplicate(array $attributes, Request $request, array $statuses): ?ContactRequest
    {
        $ip = $request->ip();
        if ($ip === null) {
            return null;
        }

        $email = $this->nullableString($attributes['email'] ?? null);
        $phone = $this->nullableString($attributes['phone'] ?? null);

        if ($email === 'consultation-lead@suavecreators.com') {
            $email = null;
        }

        if ($email === null && $phone === null) {
            return null;
        }

        return ContactRequest::query()
            ->where('ip_address', $ip)
            ->whereIn('status', $statuses)
            ->where('created_at', '>=', now()->subMinutes(self::DUPLICATE_WINDOW_MINUTES))
            ->where(function ($query) use ($email, $phone): void {
                if ($email !== null) {
                    $query->orWhere('email', $email);
                }

                if ($phone !== null) {
                    $query->orWhere('phone', $phone);
                }
            })
            ->latest('id')
            ->first();
    }

    private function hasTooManyRecentFinalSubmissions(Request $request): bool
    {
        $ip = $request->ip();
        if ($ip === null) {
            return false;
        }

        return ContactRequest::query()
            ->where('ip_address', $ip)
            ->whereIn('status', [
                ContactRequest::STATUS_NEW,
                ContactRequest::STATUS_READ,
            ])
            ->where('created_at', '>=', now()->subMinutes(self::FLOOD_WINDOW_MINUTES))
            ->count() >= self::MAX_RECENT_FINAL_SUBMISSIONS_PER_IP;
    }

    private function hasTooManyRecentDrafts(Request $request): bool
    {
        $ip = $request->ip();
        if ($ip === null) {
            return false;
        }

        return ContactRequest::query()
            ->where('ip_address', $ip)
            ->where('status', ContactRequest::STATUS_DRAFT)
            ->where('created_at', '>=', now()->subMinutes(self::FLOOD_WINDOW_MINUTES))
            ->count() >= self::MAX_RECENT_DRAFTS_PER_IP;
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function userAgent(Request $request): ?string
    {
        $agent = $request->userAgent();

        return $agent ? Str::limit($agent, 500, '') : null;
    }
}
