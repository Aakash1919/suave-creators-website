<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnologyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_technologies_page_renders_every_section(): void
    {
        $response = $this->get(route('technologies', absolute: false));

        $response->assertOk();
        $response->assertSee('Technologies &', false);
        $response->assertSee('<strong>Laravel (PHP)</strong>', false);
        $response->assertSee('<strong>Shopify Plus</strong> and <strong>Magento (Adobe Commerce)</strong>', false);
        $response->assertDontSee('technologies-hero__name-icon', false);
        $response->assertSee('assets/icons/tech/laravel-mark-logo.svg', false);
        $response->assertSee('assets/icons/tech/nodedotjs.svg', false);
        $response->assertSee('assets/icons/tech/react.svg', false);
        $response->assertSee('assets/icons/tech/angular.svg', false);
        $response->assertSee('assets/icons/tech/vuedotjs.svg', false);
        $response->assertSee('assets/icons/tech/wordpress.svg', false);
        $response->assertSee('assets/icons/tech/shopify-technology-icon.png', false);
        $response->assertSee('assets/icons/tech/magento.svg', false);
        $response->assertSee('assets/background/technologies-hero-bg.webp', false);
        $response->assertSee('assets/media/technology-hero.webp', false);
        $response->assertSee('technologies-hero__image', false);
        $response->assertSee('assets/icons/ownership-logo.webp', false);
        $response->assertSee('assets/icons/admin-logo.webp', false);
        $response->assertSee('assets/icons/time-sprint-logo.webp', false);
        $response->assertDontSee('technologies-hero__image-placeholder', false);
        $response->assertDontSee('technologies-hero__device-placeholder', false);
        $response->assertSeeInOrder([
            'technologies-stack__title-our',
            'Our',
            'technologies-stack__title-accent',
            'Technology Stack',
        ], false);
        $response->assertSee('class="technologies-stack__logo"', false);
        $response->assertDontSee('technologies-stack__logo-placeholder', false);
        $response->assertSee('class="technologies-backend__logo"', false);
        $response->assertSee('class="technologies-backend__pick-logo"', false);
        $response->assertSee('class="technologies-frontend__logo"', false);
        $response->assertSee('assets/icons/green-circle-check-icon.png', false);
        $response->assertSee('class="technologies-mobile__logo"', false);
        $response->assertSee('assets/icons/ios-android-notification-icon.webp', false);
        $response->assertSee('assets/icons/share-nodes-icon.webp', false);
        $response->assertSee('assets/icons/native-code-brackets-icon.webp', false);
        $response->assertSee('assets/icons/api-first-link-icon.webp', false);
        $response->assertDontSee('technologies-mobile__feature-icon-placeholder', false);
        $response->assertSee('class="technologies-cms__logo"', false);
        $response->assertSee('assets/icons/tech/cms-speech-bubble-logo.webp', false);
        $response->assertSee('class="technologies-commerce__logo"', false);
        $response->assertDontSee('technologies-cms__logo-placeholder', false);
        $response->assertDontSee('technologies-backend__logo-placeholder', false);
        $response->assertDontSee('technologies-backend__pick-placeholder', false);
        $response->assertDontSee('technologies-frontend__logo-placeholder', false);
        $response->assertDontSee('technologies-mobile__logo-placeholder', false);
        $response->assertDontSee('technologies-commerce__logo-placeholder', false);
        $response->assertDontSee('technologies-selection__logo-placeholder', false);
        $response->assertSeeInOrder([
            'technologies-backend',
            'assets/background/technologies-backend-bg.webp',
            'technologies-cms',
            'assets/background/technologies-backend-bg.webp',
        ], false);
        $response->assertSee('assets/background/technologies-mobile-bg.webp', false);
        $response->assertSee('Backend Development', false);
        $response->assertSee('class="technologies-backend__summary-copy"', false);
        $response->assertSee('technologies-backend__more', false);
        $response->assertSee('Read more', false);
        $response->assertSee('data-technologies-backend-more', false);
        $response->assertSee('Laravel is an open-source PHP web framework', false);
        $response->assertSee('Google&#039;s V8 engine', false);
        $response->assertSee('React, Angular and Vue.js', false);
        $response->assertSee('Mobile Application Development with', false);
        $response->assertSee('Why businesses choose it', false);
        $response->assertSee('id="laravel"', false);
        $response->assertSee('id="react-native"', false);
        $response->assertSee('model-view-controller (MVC)', false);
        $response->assertSee('Watch-out', false);
        $response->assertSee('Go headless when', false);
        $response->assertSee('Stay traditional when', false);
        $response->assertSee('Laravel or Node.js?', false);
        $response->assertSee('Headless CMS', false);
        $response->assertSee('Shopify Plus', false);
        $response->assertSee('How These Technologies Work Together', false);
        $response->assertSee('Custom CRM or ERP', false);
        $response->assertSee('technologies-combinations__pill', false);
        $response->assertSee('technologies-combinations__need-text', false);
        $response->assertSee('Build scalable systems with complex data, roles and workflows.', false);
        $response->assertSee('Laravel API', false);
        $response->assertDontSee('technologies-combinations__logo-placeholder', false);
        $response->assertSee('How We Choose a', false);
        $response->assertSee('technologies-selection__checks', false);
        $response->assertSee('technologies-selection__result-lines', false);
        $response->assertSee('Right stack.', false);
        $response->assertSee('Real results.', false);
        $response->assertSee('technologies-selection__factors', false);
        $response->assertSee('technologies-selection__factor-icon', false);
        $response->assertSee('technologies-selection__factor--pink', false);
        $response->assertSee('Data and business logic.', false);
        $response->assertSee('Total cost of ownership.', false);
        $response->assertSee('Build With Suave Creators', false);
        $response->assertSee('assets/icons/developers-code-gear-icon.webp', false);
        $response->assertSee('assets/icons/code-ip-ownership-icon.webp', false);
        $response->assertSee('assets/icons/sprint-calendar-icon.webp', false);
        $response->assertSee('assets/icons/documented-decisions-icon.webp', false);
        $response->assertDontSee('technologies-why__icon-placeholder', false);
        $response->assertSee('What technologies does Suave Creators use?', false);
        $response->assertSee('Technology FAQs', false);
        $response->assertSee('Get a Scoped Estimate', false);
        $response->assertSee('href="#contact-modal"', false);
        $response->assertSee(route('industry.show', ['slug' => 'logistics-supply-chain-apps']), false);
        $response->assertSee('Web &amp; Software Development Technology Stack | Suave Creators', false);
        $response->assertSee('Laravel (PHP) development', false);
        $response->assertSee('Discuss Your Technology Stack With a Solution Architect', false);
        $response->assertSee('Our Partnerships', false);
        $response->assertSee('verysoul-logo.png', false);
        $response->assertDontSee('What is a custom CRM builder?', false);
        $response->assertDontSee('turbo-trans-corporation-logo.png', false);
        $response->assertSee(route('service.show', ['slug' => 'ai-solutions']), false);
        $response->assertSee(route('case-studies'), false);
        $response->assertSee('iOS and Android apps from one codebase', false);
        $response->assertDontSee('one shared codebase', false);
    }

    public function test_technologies_page_json_ld_uses_hash_fragments(): void
    {
        $response = $this->get(route('technologies', absolute: false));

        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());
        $pageUrl = rtrim(route('technologies'), '/');
        $byType = [];

        foreach ($graph as $node) {
            $type = $node['@type'] ?? null;

            if (is_string($type)) {
                $byType[$type] = $node;
            }
        }

        $this->assertSame($pageUrl.'#technology-list', $byType['ItemList']['@id'] ?? null);
        $this->assertSame(9, $byType['ItemList']['numberOfItems'] ?? null);
        $this->assertCount(9, $byType['ItemList']['itemListElement'] ?? []);
        $this->assertSame(
            $pageUrl.'#laravel-development',
            $byType['ItemList']['itemListElement'][0]['item']['@id'] ?? null
        );
        $this->assertSame(
            $pageUrl.'#laravel',
            $byType['ItemList']['itemListElement'][0]['item']['url'] ?? null
        );
        $this->assertSame($pageUrl.'#faq', $byType['FAQPage']['@id'] ?? null);
        $this->assertSame('FAQPage', $byType['FAQPage']['@type'] ?? null);

        $about = $byType['WebPage']['about'] ?? [];
        $this->assertIsArray($about);
        $this->assertSame('Laravel', $about[0]['name'] ?? null);
        $this->assertSame('https://en.wikipedia.org/wiki/Laravel', $about[0]['sameAs'] ?? null);
        $this->assertSame($pageUrl.'#technology-list', $byType['WebPage']['mainEntity']['@id'] ?? null);
    }

    public function test_technologies_page_is_linked_from_the_header_and_footer(): void
    {
        $response = $this->get(route('home', absolute: false));

        $response->assertOk();
        $response->assertSee('href="'.route('technologies').'"', false);
        $response->assertSee('>Technology</a>', false);
        $response->assertSee('Technologies</span>', false);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function jsonLdGraph(string $html): array
    {
        $this->assertSame(1, preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches));

        $decoded = json_decode(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5), true);
        $this->assertIsArray($decoded);

        $graph = $decoded['@graph'] ?? null;
        $this->assertIsArray($graph);

        return array_values($graph);
    }
}
