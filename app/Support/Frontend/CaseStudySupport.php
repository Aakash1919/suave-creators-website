<?php

namespace App\Support\Frontend;

use Illuminate\Support\Str;

class CaseStudySupport
{
    /**
     * @return list<array<string, mixed>>
     */
    public static function cases(): array
    {
        /** @var list<array<string, mixed>> $cases */
        $cases = require __DIR__.'/Data/case-studies/cases.php';

        return array_map([self::class, 'mapCase'], $cases);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function case(string $slug): ?array
    {
        foreach (self::cases() as $case) {
            if (($case['slug'] ?? '') === $slug) {
                return $case;
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        return [
            'cases' => self::cases(),
            'seoTitle' => 'Case Studies | Suave Creators',
            'seoDescription' => 'See how Suave Creators designs and ships real products — starting with Suave CRM Outreach, a map-first workspace for finding companies and drafting outreach with AI.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $case = self::case($slug);

        if ($case === null) {
            abort(404);
        }

        return [
            'case' => $case,
            'seoTitle' => $case['title'].' | Case Study | Suave Creators',
            'seoDescription' => $case['short_description'] ?? '',
            'seoImage' => $case['image'] ?? null,
        ];
    }

    public static function visualForSection(array $section, int $index): string
    {
        if (! empty($section['visual'])) {
            return (string) $section['visual'];
        }

        $eyebrow = strtolower((string) ($section['eyebrow'] ?? ''));

        if (str_contains($eyebrow, 'discover')) {
            return 'discovery';
        }

        if (str_contains($eyebrow, 'prepar') || str_contains($eyebrow, 'intel')) {
            return 'preparation';
        }

        if (str_contains($eyebrow, 'pipeline') || str_contains($eyebrow, 'lead')) {
            return 'pipeline';
        }

        return ['discovery', 'preparation', 'pipeline'][$index % 3];
    }

    /**
     * @param  array<string, mixed>  $case
     * @return array<string, mixed>
     */
    protected static function mapCase(array $case): array
    {
        if (! empty($case['image']) && ! Str::startsWith((string) $case['image'], ['http://', 'https://'])) {
            $case['image'] = asset(ltrim((string) $case['image'], '/'));
        }

        return $case;
    }
}
