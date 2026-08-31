<?php

namespace App\Http\Controllers\Frontend;

use App\Ai\Agents\SuaveAgent;
use App\Models\ChatLead;
use App\Services\CrmLeadSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Ai\Models\Conversation;
use Laravel\Ai\Models\ConversationMessage;
use Laravel\Ai\Responses\StreamableAgentResponse;

class SuaveAgentController extends FrontendController
{
    /**
     * Create a ChatLead + conversation session with an instant greeting.
     *
     * @return array{lead_uuid: string, session_token: string, conversation_id: string, greeting: string, escalated: bool, lead: array{name: string, email: string}}
     */
    public static function createLeadSession(string $name, string $contact): array
    {
        $contact = trim($contact);
        $name = trim($name);

        if ($name === '') {
            if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                $name = ucfirst(Str::before($contact, '@'));
            } else {
                $name = 'Guest';
            }
        }

        $plainToken = Str::random(48);
        $greeting = (new self)->instantGreeting($name, $contact);

        [$lead, $conversationId] = DB::transaction(function () use ($name, $contact, $plainToken, $greeting): array {
            $lead = ChatLead::query()->create([
                'name' => $name,
                'email' => $contact,
                'session_token' => ChatLead::hashSessionToken($plainToken),
            ]);

            $conversationId = (string) Str::uuid7();

            Conversation::query()->create([
                'id' => $conversationId,
                'participant_type' => $lead->getMorphClass(),
                'participant_id' => $lead->getKey(),
                'title' => 'Chat with '.$lead->name,
            ]);

            ConversationMessage::query()->create([
                'id' => (string) Str::uuid7(),
                'conversation_id' => $conversationId,
                'participant_type' => $lead->getMorphClass(),
                'participant_id' => $lead->getKey(),
                'agent' => SuaveAgent::class,
                'role' => 'assistant',
                'content' => $greeting,
                'attachments' => [],
                'tool_calls' => [],
                'tool_results' => [],
                'usage' => [],
                'meta' => [],
                'approval_state' => null,
            ]);

            return [$lead, $conversationId];
        });

        return [
            'lead_uuid' => $lead->uuid,
            'session_token' => $plainToken,
            'conversation_id' => $conversationId,
            'greeting' => $greeting,
            'escalated' => false,
            'lead' => [
                'name' => $lead->name,
                'email' => $lead->email,
            ],
        ];
    }

    /**
     * Create a ChatLead + conversation with an instant greeting (no LLM wait).
     */
    public function start(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
        ]);

        $contact = $validated['contact'] ?? $validated['email'] ?? null;
        if (blank($contact)) {
            throw ValidationException::withMessages([
                'email' => 'Please provide a valid email or phone number.',
            ]);
        }

        $sessionData = self::createLeadSession((string) ($validated['name'] ?? ''), (string) $contact);

        return response()->json($sessionData);
    }

    /**
     * Stream an assistant reply for an authenticated lead conversation.
     */
    public function chat(Request $request): StreamableAgentResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
            'lead_uuid' => ['required', 'uuid'],
            'session_token' => ['required', 'string'],
            'conversation_id' => ['required', 'uuid'],
        ]);

        $lead = $this->authorizeLead($validated['lead_uuid'], $validated['session_token']);
        $this->authorizeConversation($validated['conversation_id'], $lead);

        return (new SuaveAgent($lead))
            ->continue($validated['conversation_id'], as: $lead)
            ->stream($validated['message'])
            ->then(function () use ($lead): void {
                app(CrmLeadSyncService::class)->syncChat($lead->fresh() ?? $lead);
            });
    }

    /**
     * Return persisted messages for a lead session (hides the legacy internal greeting prompt).
     */
    public function history(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lead_uuid' => ['required', 'uuid'],
            'session_token' => ['required', 'string'],
            'conversation_id' => ['nullable', 'uuid'],
        ]);

        $lead = $this->authorizeLead($validated['lead_uuid'], $validated['session_token']);

        $conversation = null;
        if (! empty($validated['conversation_id'])) {
            $conversation = $this->authorizeConversation($validated['conversation_id'], $lead);
        } else {
            $conversation = $lead->conversations()->latest('updated_at')->first();
        }

        if ($conversation === null) {
            return response()->json([
                'conversation_id' => null,
                'escalated' => $lead->escalated_at !== null,
                'messages' => [],
                'lead' => [
                    'name' => $lead->name,
                    'email' => $lead->email,
                ],
            ]);
        }

        $messages = $conversation->messages()
            ->orderBy('created_at')
            ->get(['id', 'role', 'content', 'created_at'])
            ->filter(fn ($message): bool => in_array($message->role, ['user', 'assistant'], true))
            ->filter(fn ($message): bool => filled($message->content))
            ->reject(fn ($message): bool => $message->role === 'user' && str_starts_with((string) $message->content, 'Hello. My name is'))
            ->values()
            ->map(fn ($message): array => [
                'id' => $message->id,
                'role' => $message->role,
                'content' => $message->content,
                'created_at' => optional($message->created_at)?->toIso8601String(),
            ]);

        return response()->json([
            'conversation_id' => $conversation->id,
            'escalated' => $lead->escalated_at !== null,
            'messages' => $messages,
            'lead' => [
                'name' => $lead->name,
                'email' => $lead->email,
            ],
        ]);
    }

    /**
     * Instant first reply shown after name/email/phone — no model round-trip.
     */
    protected function instantGreeting(string $name, string $contact = ''): string
    {
        $contact = trim($contact);
        $name = trim($name);

        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);
        $isPhone = ! $isEmail && $contact !== '';

        if ($isPhone || $name === '' || in_array(strtolower($name), ['guest', 'visitor', 'valued guest', 'valued'], true)) {
            return "Hi there! 👋\n\nThanks for reaching out! Whether you're planning a new web or mobile app, custom software, or scaling an existing platform — we'd love to help bring it to life.\n\nWhat is the main goal or idea you're looking to build?";
        }

        $firstName = trim(Str::before($name, ' ')) ?: $name;

        return "Hi **{$firstName}**! 👋\n\nThanks for reaching out! Whether you're planning a new web or mobile app, custom software, or scaling an existing platform — we'd love to help bring it to life.\n\nWhat is the main goal or idea you're looking to build?";
    }

    /**
     * Resolve a ChatLead only when the plain session token matches the stored hash.
     *
     * @throws ValidationException
     */
    protected function authorizeLead(string $uuid, string $sessionToken): ChatLead
    {
        $lead = ChatLead::query()->where('uuid', $uuid)->first();

        if ($lead === null || ! $lead->plainSessionTokenMatches($sessionToken)) {
            throw ValidationException::withMessages([
                'session_token' => 'Invalid chat session.',
            ]);
        }

        return $lead;
    }

    /**
     * Ensure the conversation belongs to the given ChatLead participant.
     *
     * @throws ValidationException
     */
    protected function authorizeConversation(string $conversationId, ChatLead $lead): Conversation
    {
        $conversation = Conversation::query()->find($conversationId);

        if (
            $conversation === null
            || $conversation->participant_type !== $lead->getMorphClass()
            || (string) $conversation->participant_id !== (string) $lead->getKey()
        ) {
            throw ValidationException::withMessages([
                'conversation_id' => 'Conversation not found for this lead.',
            ]);
        }

        return $conversation;
    }
}
