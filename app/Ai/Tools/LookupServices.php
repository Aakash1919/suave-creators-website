<?php

namespace App\Ai\Tools;

use App\Support\Frontend\SuaveAgentKnowledge;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class LookupServices implements Tool
{
    public function description(): Stringable|string
    {
        return 'Look up Suave Creators software and digital services. Omit slug for the full catalog, or pass a service slug for details.';
    }

    public function handle(Request $request): Stringable|string
    {
        $slug = trim((string) ($request['slug'] ?? ''));

        if ($slug === '') {
            return json_encode([
                'catalog' => SuaveAgentKnowledge::servicesCatalog(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{"catalog":[]}';
        }

        $detail = SuaveAgentKnowledge::serviceDetail($slug);

        if ($detail === null) {
            return json_encode([
                'error' => 'Service not found',
                'available_slugs' => array_values(array_filter(array_column(SuaveAgentKnowledge::servicesCatalog(), 'slug'))),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{"error":"Service not found"}';
        }

        return json_encode(['service' => $detail], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'slug' => $schema->string()->description('Optional service slug such as web-development-services'),
        ];
    }
}
