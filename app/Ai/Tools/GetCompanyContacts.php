<?php

namespace App\Ai\Tools;

use App\Support\Frontend\SuaveAgentKnowledge;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetCompanyContacts implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get Suave Creators office addresses, phone numbers, and email contacts. Use when the visitor asks how to reach the company.';
    }

    public function handle(Request $request): Stringable|string
    {
        return json_encode(
            SuaveAgentKnowledge::companyContacts(),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ) ?: '{}';
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
