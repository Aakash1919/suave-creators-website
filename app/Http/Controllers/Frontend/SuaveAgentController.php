<?php

namespace App\Http\Controllers\Frontend;

use App\Ai\Agents\SuaveAgent;
use App\Models\ChatLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Ai\Models\Conversation;
use Laravel\Ai\Responses\StreamableAgentResponse;

class SuaveAgentController extends FrontendController
{
    /**
     * Create a ChatLead, run the greeting prompt, and return session credentials.
     */
    public function start(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $plainToken = Str::random(48);

        $lead = ChatLead::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'session_token' => ChatLead::hashSessionToken($plainToken),
        ]);

        $agent = (new SuaveAgent($lead))->forParticipant($lead);

        $prompt = sprintf(
            'Hello. My name is %s and my email is %s. Please greet me warmly as a Suave Creators sales representative, invite me to discuss my project, and briefly mention that you can share details about the services and industries Suave Creators serves.',
            $lead->name,
            $lead->email,
        );

        $response = $agent->prompt($prompt);

        return response()->json([
            'lead_uuid' => $lead->uuid,
            'session_token' => $plainToken,
            'conversation_id' => $response->conversationId ?? $agent->currentConversation(),
            'greeting' => $response->text,
            'escalated' => $lead->fresh()?->escalated_at !== null,
            'lead' => [
                'name' => $lead->name,
                'email' => $lead->email,
            ],
        ]);
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
            ->stream($validated['message']);
    }

    /**
     * Return persisted messages for a lead session (hides the internal greeting prompt).
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
