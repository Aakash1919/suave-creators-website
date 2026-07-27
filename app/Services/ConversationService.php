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
     * @return Collection<int, array{id: mixed, title: mixed, updated_at: mixed, messages: Collection<int, array<string, mixed>>}>
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

            return [
                'id' => $conversation->id,
                'title' => $conversation->title,
                'updated_at' => $conversation->updated_at,
                'messages' => $messages,
            ];
        });
    }
}
