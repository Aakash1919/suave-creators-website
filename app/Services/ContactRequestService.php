<?php

namespace App\Services;

use App\Http\Requests\Frontend\ContactDraftRequest;
use App\Http\Requests\Frontend\ContactStoreRequest;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactRequestService
{
    public const MIN_SUBMIT_SECONDS = 3;

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

        return $elapsed < self::MIN_SUBMIT_SECONDS || $elapsed > 86_400;
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

        return ContactRequest::query()->create([
            ...$attributes,
            'draft_token' => $token,
            'status' => ContactRequest::STATUS_DRAFT,
            'ip_address' => $request->ip(),
            'user_agent' => $this->userAgent($request),
        ]);
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
