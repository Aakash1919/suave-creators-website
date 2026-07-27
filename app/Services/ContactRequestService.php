<?php

namespace App\Services;

use App\Models\ContactRequest;
use App\Support\Frontend\ContactSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ContactRequestService
{
    public const MIN_SUBMIT_SECONDS = 3;

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
     * Validate and persist a legitimate contact request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): ContactRequest
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:60'],
            'service' => ['required', 'string', Rule::in(array_keys(ContactSupport::formServices()))],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

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
