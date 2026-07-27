<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoGenerateService;
use Illuminate\View\View;

abstract class FrontendController extends Controller
{
    /**
     * Render a marketing view with SEO shared from the controller.
     *
     * @param  array<string, mixed>  $data
     */
    protected function view(string $name, array $data = [], bool $withSeo = true): View
    {
        $payload = array_merge($data, [
            'withSeo' => $withSeo,
        ]);

        if ($withSeo) {
            $overrides = array_filter([
                'title' => $data['seoTitle'] ?? null,
                'description' => $data['seoDescription'] ?? null,
                'image' => $data['seoImage'] ?? null,
                'faqs' => $data['seoFaqs'] ?? null,
            ], static fn (mixed $value): bool => $value !== null && $value !== '');

            $payload['seo'] = app(SeoGenerateService::class)->generate($overrides);
        } else {
            $payload['seo'] = [];
        }

        return view($name, $payload);
    }
}
