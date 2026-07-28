<?php

namespace App\Http\Controllers\Frontend;

use App\Services\SitemapService;
use Illuminate\Http\Response;

class SitemapController extends FrontendController
{
    public function __construct(
        private readonly SitemapService $sitemap,
    ) {}

    /**
     * XML sitemap for search engines.
     */
    public function xml(): Response
    {
        return response($this->sitemap->toXml(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Markdown site map for LLMs / SEO assistants (`/llm.txt` and `/llms.txt`).
     */
    public function llmTxt(): Response
    {
        return response($this->sitemap->toLlmText(), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Dynamic robots.txt with Sitemap + LLM pointers.
     */
    public function robots(): Response
    {
        return response($this->sitemap->robotsTxt(), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
