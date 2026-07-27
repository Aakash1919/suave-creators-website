<?php

namespace App\Ai\Tools;

use App\Support\Frontend\IndustryDetailSupport;
use App\Support\Frontend\SuaveAgentKnowledge;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class LookupIndustries implements Tool
{
    public function description(): Stringable|string
    {
        return 'Look up Suave Creators industry solutions. Omit slug for the catalog, or pass an industry slug for details.';
    }

    public function handle(Request $request): Stringable|string
    {
        $slug = trim((string) ($request['slug'] ?? ''));

        if ($slug === '') {
            return json_encode([
                'catalog' => SuaveAgentKnowledge::industriesCatalog(),
                'available_slugs' => array_keys(IndustryDetailSupport::SLUG_FILES),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{"catalog":[]}';
        }

        $detail = SuaveAgentKnowledge::industryDetail($slug);

        if ($detail === null) {
            return json_encode([
                'error' => 'Industry not found',
                'available_slugs' => array_keys(IndustryDetailSupport::SLUG_FILES),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{"error":"Industry not found"}';
        }

        return json_encode(['industry' => $detail], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'slug' => $schema->string()->description('Optional industry slug such as healthcare'),
        ];
    }
}
