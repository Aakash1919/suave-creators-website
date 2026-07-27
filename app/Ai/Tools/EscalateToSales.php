<?php

namespace App\Ai\Tools;

use App\Models\ChatLead;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class EscalateToSales implements Tool
{
    public function __construct(public ChatLead $lead) {}

    public function description(): Stringable|string
    {
        return 'Escalate the conversation to a human sales representative when the request is beyond the AI agent scope (custom quotes needing discovery, legal/financial guarantees, complaints, or unrelated topics).';
    }

    public function handle(Request $request): Stringable|string
    {
        $this->lead->markEscalated();

        $reason = trim((string) ($request['reason'] ?? 'Request requires a human sales follow-up.'));

        return json_encode([
            'escalated' => true,
            'reason' => $reason,
            'message_for_user' => 'Thank you for sharing those details. This is a bit beyond what I can finalize here, so one of our sales representatives will contact you shortly using the email you provided.',
            'lead_email' => $this->lead->email,
            'lead_name' => $this->lead->name,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{"escalated":true}';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'reason' => $schema->string()->description('Brief reason the request needs a human sales follow-up')->required(),
        ];
    }
}
