<?php

namespace App\Services;

use App\Models\ChatLead;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ConversationService
{
    /**
     * Build display threads for a chat lead (Markdown for assistant, escaped user text).
     *
     * @return Collection<int, array{id: mixed, title: string, updated_at: mixed, preview: string, message_count: int, messages: Collection<int, array<string, mixed>>}>
     */
    public function threadsForLead(ChatLead $lead): Collection
    {
        $conversations = $lead->conversations()
            ->with(['messages' => fn ($q) => $q->orderBy('created_at')])
            ->latest('updated_at')
            ->get();

        return $conversations->map(function ($conversation) {
            $messages = $conversation->messages
                ->filter(fn ($message): bool => in_array($message->role, ['user', 'assistant'], true))
                ->filter(fn ($message): bool => filled($message->content))
                ->reject(fn ($message): bool => $message->role === 'user' && str_starts_with((string) $message->content, 'Hello. My name is'))
                ->values()
                ->map(function ($message): array {
                    $content = (string) $message->content;
                    $html = $message->role === 'assistant'
                        ? Str::markdown($content, [
                            'html_input' => 'strip',
                            'allow_unsafe_links' => false,
                        ])
                        : e($content);

                    return [
                        'id' => $message->id,
                        'role' => $message->role,
                        'content' => $content,
                        'html' => $html,
                        'created_at' => $message->created_at,
                    ];
                });

            $last = $messages->last();
            $preview = $last
                ? Str::limit(preg_replace('/\s+/', ' ', strip_tags((string) $last['content'])) ?: '', 72)
                : 'No messages yet';

            return [
                'id' => $conversation->id,
                'title' => filled($conversation->title) ? (string) $conversation->title : 'Conversation',
                'updated_at' => $conversation->updated_at,
                'preview' => $preview,
                'message_count' => $messages->count(),
                'messages' => $messages,
            ];
        });
    }

    /**
     * Initials for messenger avatars.
     */
    public function initialsFor(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name) ?: 'SC') ?: ['SC'];

        return collect($parts)
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr((string) $part, 0, 1)))
            ->implode('') ?: 'SC';
    }
}
