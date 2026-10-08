<?php

namespace Tests\Feature;

use App\Support\Frontend\ServiceSupport;
use App\View\Components\Layouts\Footer;
use App\View\Components\Layouts\Header;
use Tests\TestCase;

class DigitalMarketingServicesPageTest extends TestCase
{
    public function test_digital_marketing_page_renders_hero_and_seo_channel(): void
    {
        $this->assertContains('digital-marketing-services', ServiceSupport::SLUGS);

        $service = ServiceSupport::service('digital-marketing-services');
        $this->assertNotNull($service);
        $this->assertSame(
            'Digital Marketing Services for B2B | Suave Creators',
            $service['pageTitle'] ?? '',
        );
        $this->assertLessThanOrEqual(60, strlen((string) ($service['pageTitle'] ?? '')));
        $this->assertLessThanOrEqual(160, strlen((string) ($service['pageDescription'] ?? '')));
        $this->assertStringContainsString(
            'digital-marketing-hero.webp',
            (string) ($service['radarVisualImage'] ?? ''),
        );
        $this->assertCount(3, $service['radarProofPoints'] ?? []);
        $this->assertSame('Search Engine Optimization (SEO)', $service['seoChannel']['title'] ?? '');
        $this->assertCount(6, $service['seoChannel']['covers'] ?? []);

        $response = $this->get(route('service.show', ['slug' => 'digital-marketing-services']));

        $response->assertOk();
        $response->assertSee('marketing-radar-hero', false);
        $response->assertSee('site-shell--digital-marketing', false);
        $response->assertSee('Digital Marketing Services for', false);
        $response->assertSee('Get a Scoped Estimate', false);
        $response->assertSee('arrow-down-circle-icon.svg', false);
        $response->assertSee('digital-marketing-hero.webp', false);
        $response->assertSee('marketing-radar-hero__proof', false);
        $response->assertSee('Search, paid, content and social under one strategy', false);
        $response->assertSee('marketing-channel-detail', false);
        $response->assertSee('Search Engine Optimization (SEO)', false);
        $response->assertSee('What our SEO service covers', false);
        $response->assertSee('Technical SEO', false);
        $response->assertSee('When SEO is the right investment', false);
        $response->assertSee('high-intent organic discovery', false);
        $response->assertSee('Our engineers implement fixes instead of handing over a list', false);
        $response->assertSee('Web application development', false);
        $response->assertSee(route('service.show', ['slug' => 'web-development-services'], false), false);
        $response->assertDontSee('service-scope-heading', false);
        $response->assertDontSee('service-faq-heading', false);
        $response->assertDontSee('marketing-radar-hero__channels', false);
    }

    public function test_header_and_footer_link_digital_marketing(): void
    {
        $header = new Header;
        $services = collect($header->dropdowns)->firstWhere('slug', 'services');
        $labels = array_column($services['items'] ?? [], 'label');
        $this->assertContains('Digital Marketing', $labels);

        $footerLabels = array_column((new Footer)->columns['Services'], 'label');
        $this->assertContains('Digital marketing', $footerLabels);
    }
}
