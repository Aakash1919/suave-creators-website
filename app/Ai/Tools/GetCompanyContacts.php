<?php

namespace App\Ai\Tools;

use App\Support\Frontend\SuaveAgentKnowledge;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetCompanyContacts implements Tool
{
    /**
     * Describe when the model should fetch company contact details.
     */
    public function description(): Stringable|string
    {
        return 'Get Suave Creators office addresses, phone numbers, and email contacts. Use when the visitor asks how to reach the company.';
    }

    /**
     * Return authoritative offices, phones, and email as JSON.
     */
    public function handle(Request $request): Stringable|string
    {
        return json_encode(
            SuaveAgentKnowledge::companyContacts(),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ) ?: '{}';
    }

    /**
     * No arguments required for contact lookup.
     *
     * @return array<string, mixed>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
