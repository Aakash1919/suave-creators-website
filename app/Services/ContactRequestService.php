<?php

namespace App\Services;

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
        $honeypot = trim((string) $request->input('website', ''));
        if ($honeypot !== '') {
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
     * Persist a legitimate contact request (validation happens in ContactStoreRequest).
     */
    public function store(ContactStoreRequest $request): ContactRequest
    {
        $data = $request->validated();
        $agent = $request->userAgent();

        return ContactRequest::query()->create([
            ...$data,
            'status' => ContactRequest::STATUS_NEW,
            'ip_address' => $request->ip(),
            'user_agent' => $agent ? Str::limit($agent, 500, '') : null,
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
}
