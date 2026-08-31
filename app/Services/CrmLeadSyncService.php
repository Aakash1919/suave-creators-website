<?php

namespace App\Services;

use App\Jobs\SyncWebsiteLeadToCrmJob;
use App\Models\ChatLead;
use App\Models\ContactRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class CrmLeadSyncService
{
    public const SOURCE_CONTACT = 'contact';

    public const SOURCE_CHAT = 'chat';

    /**
     * Whether CRM webhook env is configured.
     */
    public function isConfigured(): bool
    {
        return filled(config('services.crm_leads.webhook_url'))
            && filled(config('services.crm_leads.webhook_token'));
    }

    /**
     * Queue a contact-form lead sync after a final submit.
     */
    public function queueContact(ContactRequest $contact): void
    {
        if (! $this->isConfigured() || $contact->isDraft()) {
            return;
        }

        SyncWebsiteLeadToCrmJob::dispatch(self::SOURCE_CONTACT, (string) $contact->id);
    }

    /**
     * Queue a SuaveAgent chat transcript sync.
     */
    public function queueChat(ChatLead $lead, ?string $firstInboundBody = null): void
    {
        if (! $this->isConfigured()) {
            return;
        }

        SyncWebsiteLeadToCrmJob::dispatch(self::SOURCE_CHAT, $lead->uuid, $firstInboundBody);
    }

    /**
     * Build and POST the CRM payload (best-effort; 4xx is logged, 5xx retries).
     */
    public function sync(string $source, string $sourceId, ?string $firstInboundBody = null): void
    {
        if (! $this->isConfigured()) {
            return;
        }

        $payload = $source === self::SOURCE_CHAT
            ? $this->chatPayload($sourceId, $firstInboundBody)
            : $this->contactPayload($sourceId);

        if ($payload === null) {
            return;
        }

        $url = (string) config('services.crm_leads.webhook_url');
        $token = (string) config('services.crm_leads.webhook_token');

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->post($url, $payload);

            if ($response->clientError()) {
                Log::warning('CRM website lead webhook client error', [
                    'status' => $response->status(),
                    'source' => $source,
                    'source_id' => $sourceId,
                    'body' => $response->body(),
                ]);

                return;
            }

            if ($response->failed()) {
                $response->throw();
            }
        } catch (RequestException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    /**
     * @return array<string, mixed>|null
     */
    private function contactPayload(string $sourceId): ?array
    {
        $contact = ContactRequest::query()->find($sourceId);
        if ($contact === null || $contact->isDraft()) {
            return null;
        }

        $service = $contact->serviceLabel();
        if ($service === '—') {
            $service = trim((string) $contact->service);
        }

        return [
            'source' => self::SOURCE_CONTACT,
            'source_id' => (string) $contact->id,
            'name' => $contact->displayName(),
            'email' => $this->nullableString($contact->email),
            'phone' => $this->nullableString($contact->phone),
            'service' => filled($service) ? $service : null,
            'message' => $this->nullableString($contact->message),
            'messages' => [],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function chatPayload(string $sourceId, ?string $firstInboundBody): ?array
    {
        $lead = ChatLead::query()->where('uuid', $sourceId)->first();
        if ($lead === null) {
            return null;
        }

        $channels = $this->chatContactChannels($lead);
        $messages = $this->chatMessages($lead, $firstInboundBody);

        return [
            'source' => self::SOURCE_CHAT,
            'source_id' => $lead->uuid,
            'name' => trim((string) $lead->name) !== '' ? trim((string) $lead->name) : 'Guest',
            'email' => $channels['email'],
            'phone' => $channels['phone'],
            'escalated' => $lead->escalated_at !== null,
            'messages' => $messages,
        ];
    }

    /**
     * @return array{email: string|null, phone: string|null}
     */
    private function chatContactChannels(ChatLead $lead): array
    {
        $contact = trim((string) $lead->email);
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL) !== false;

        return [
            'email' => $isEmail ? $contact : null,
            'phone' => $isEmail || $contact === '' ? null : $contact,
        ];
    }

    /**
     * @return list<array{body: string, side: string, occurred_at: string|null}>
     */
    private function chatMessages(ChatLead $lead, ?string $firstInboundBody): array
    {
        $turns = app(ConversationService::class)
            ->threadsForLead($lead)
            ->flatMap(fn (array $thread) => $thread['messages'])
            ->sortBy(fn (array $message): int|float => optional($message['created_at'])->timestamp ?? 0)
            ->values();

        $messages = $turns
            ->map(function (array $message): ?array {
                $role = (string) ($message['role'] ?? '');
                $body = trim((string) ($message['content'] ?? ''));
                if (blank($body) || ! in_array($role, ['user', 'assistant'], true)) {
                    return null;
                }

                $occurredAt = $message['created_at'] ?? null;

                return [
                    'body' => $body,
                    'side' => $role === 'user' ? 'theirs' : 'ours',
                    'occurred_at' => $occurredAt?->toIso8601String(),
                ];
            })
            ->filter()
            ->values()
            ->all();

        $inbound = trim((string) $firstInboundBody);
        if (
            filled($inbound)
            && ! str_starts_with($inbound, 'Hello. My name is')
            && ! $this->messagesContainBody($messages, $inbound)
        ) {
            array_unshift($messages, [
                'body' => $inbound,
                'side' => 'theirs',
                'occurred_at' => null,
            ]);
        }

        return $messages;
    }

    /**
     * @param  list<array{body: string, side: string, occurred_at: string|null}>  $messages
     */
    private function messagesContainBody(array $messages, string $body): bool
    {
        $needle = Str::squish($body);

        foreach ($messages as $message) {
            if (Str::squish((string) $message['body']) === $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Trim a nullable string.
     */
    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
