<?php

namespace Tests\Feature;

use App\Support\Frontend\ServiceSupport;
use App\View\Components\Layouts\Footer;
use App\View\Components\Layouts\Header;
use Tests\TestCase;

class DigitalMarketingServicesPageTest extends TestCase
{
    public function test_digital_marketing_page_renders_hero_and_four_channels(): void
    {
        $this->assertContains('digital-marketing-services', ServiceSupport::SLUGS);

        $service = ServiceSupport::service('digital-marketing-services');
        $this->assertNotNull($service);
        $this->assertSame(
            'Digital Marketing Services for B2B Companies | Suave Creators',
            $service['pageTitle'] ?? '',
        );
        $this->assertLessThanOrEqual(70, strlen((string) ($service['pageTitle'] ?? '')));
        $this->assertLessThanOrEqual(160, strlen((string) ($service['pageDescription'] ?? '')));
        $this->assertStringContainsString(
            'digital-marketing-hero.webp',
            (string) ($service['radarVisualImage'] ?? ''),
        );
        $this->assertCount(3, $service['radarProofPoints'] ?? []);
        $this->assertSame('Drive Business Growth', $service['overview']['title']['accent'] ?? '');
        $this->assertSame('— Four channels. One growth system.', $service['overview']['eyebrow'] ?? '');
        $this->assertCount(4, $service['overview']['rows'] ?? []);
        $this->assertSame('blue', $service['overview']['rows'][0]['theme'] ?? '');
        $this->assertSame('search', $service['overview']['rows'][0]['icon'] ?? '');
        $this->assertSame('Social media', $service['overview']['rows'][3]['service'] ?? '');
        $this->assertSame('Search Engine Optimization (SEO)', $service['seoChannel']['title'] ?? '');
        $this->assertSame('seo', $service['seoChannel']['sectionId'] ?? '');
        $this->assertCount(6, $service['seoChannel']['covers'] ?? []);
        $this->assertSame('Pay-Per-Click Advertising (PPC)', $service['ppcChannel']['title'] ?? '');
        $this->assertSame('02', $service['ppcChannel']['index'] ?? '');
        $this->assertCount(5, $service['ppcChannel']['covers'] ?? []);
        $this->assertSame('Content Marketing', $service['contentChannel']['title'] ?? '');
        $this->assertSame('03', $service['contentChannel']['index'] ?? '');
        $this->assertCount(5, $service['contentChannel']['covers'] ?? []);
        $this->assertSame('Social Media Marketing', $service['socialChannel']['title'] ?? '');
        $this->assertSame('04', $service['socialChannel']['index'] ?? '');
        $this->assertCount(5, $service['socialChannel']['covers'] ?? []);
        $this->assertSame('Full-funnel thinking', $service['funnelMatrix']['eyebrow'] ?? '');
        $this->assertSame('Digital Marketing Services', $service['funnelMatrix']['title']['accent'] ?? '');
        $this->assertCount(3, $service['funnelMatrix']['rows'] ?? []);
        $this->assertCount(2, $service['funnelMatrix']['examples'] ?? []);
        $this->assertSame('', $service['funnelMatrix']['aiVisibility']['icon'] ?? 'missing');
        $this->assertSame('How We Work', $service['howWeWork']['title'] ?? '');
        $this->assertCount(4, $service['howWeWork']['items'] ?? []);
        $this->assertSame('', $service['howWeWork']['items'][0]['image'] ?? 'missing');
        $this->assertSame('Why Suave Creators for B2B Digital Marketing', $service['whySuave']['title'] ?? '');
        $this->assertCount(4, $service['whySuave']['items'] ?? []);
        $this->assertSame('', $service['whySuave']['items'][0]['icon'] ?? 'missing');
        $this->assertSame('Digital Marketing FAQs', $service['faqTitle'] ?? '');
        $this->assertCount(12, $service['faqs'] ?? []);
        $this->assertSame('Plan Your B2B Digital Marketing Strategy', $service['consultation']['title'] ?? '');
        $this->assertStringContainsString(
            'analyst-headset-custom-crm-dashboard.webp',
            (string) ($service['consultation']['people'][0]['src'] ?? ''),
        );
        $this->assertSame('Our Partnerships & Growth Stack', $service['partnersHeading'] ?? '');

        $response = $this->get(route('service.show', ['slug' => 'digital-marketing-services']));

        $response->assertOk();
        $response->assertSee('marketing-radar-hero', false);
        $response->assertSee('site-shell--digital-marketing', false);
        $response->assertSee('Digital Marketing Services for', false);
        $response->assertSee('Get a Scoped Estimate', false);
        $response->assertDontSee('marketing-radar-hero__cta-secondary', false);
        $response->assertSee('digital-marketing-hero.webp', false);
        $response->assertSee('marketing-radar-hero__proof', false);
        $response->assertSee('Search, paid, content and social under one strategy', false);
        $response->assertSee('Content written with input from senior developers', false);
        $response->assertSee('marketing-services-overview', false);
        $response->assertSee('Four channels. One growth system.', false);
        $response->assertSee('Digital Marketing Services That', false);
        $response->assertSee('Drive Business Growth', false);
        $response->assertSee('id="overview"', false);
        $response->assertSee('Earns organic visibility for high-intent searches', false);
        $response->assertSee('marketing-services-overview__card--blue', false);
        $response->assertSee('marketing-services-overview__card--purple', false);
        $response->assertSee('marketing-services-overview__card--teal', false);
        $response->assertSee('marketing-services-overview__card--pink', false);
        $response->assertSee('Explore service', false);
        $response->assertSee('Measured by', false);
        $response->assertSee('connects four services into one strategy', false);
        $response->assertSee('marketing-channel-detail', false);
        $response->assertSee('id="seo"', false);
        $response->assertSee('Search Engine Optimization (SEO)', false);
        $response->assertSee('What our SEO service covers', false);
        $response->assertSee('Technical SEO', false);
        $response->assertSee('When SEO is the right investment', false);
        $response->assertSee('high-intent organic discovery', false);
        $response->assertSee('fixes can be implemented by our engineers instead of handed over as a list', false);
        $response->assertSee('id="ppc"', false);
        $response->assertSee('Pay-Per-Click Advertising (PPC)', false);
        $response->assertSee('02/04', false);
        $response->assertSee('What our PPC service covers', false);
        $response->assertSee('Google Ads search campaigns', false);
        $response->assertSee('PPC and SEO: different jobs', false);
        $response->assertSee('landing pages built to convert', false);
        $response->assertSee('marketing-channel-detail__rail-icon--dollar', false);
        $response->assertSee('id="content-marketing"', false);
        $response->assertSee('Content Marketing', false);
        $response->assertSee('03/04', false);
        $response->assertSee('Content we produce', false);
        $response->assertSee('How we plan content', false);
        $response->assertSee('Custom CRM vs Salesforce: 3-year TCO', false);
        $response->assertSee('marketing-channel-detail__rail-icon--blog', false);
        $response->assertSee('id="social-media-marketing"', false);
        $response->assertSee('Social Media Marketing', false);
        $response->assertSee('04/04', false);
        $response->assertSee('What our social media service covers', false);
        $response->assertSee('Why LinkedIn comes first for B2B', false);
        $response->assertSee('marketing-channel-detail__rail-icon--share', false);
        $response->assertSee('marketing-funnel-matrix', false);
        $response->assertSee('id="integrated"', false);
        $response->assertSee('How Our', false);
        $response->assertSee('Digital Marketing Services', false);
        $response->assertSee('Work Together', false);
        $response->assertSee('Full-funnel thinking', false);
        $response->assertSee('Awareness', false);
        $response->assertSee('Consideration', false);
        $response->assertSee('Decision', false);
        $response->assertSee('Ranks for problem-level questions', false);
        $response->assertSee('Visibility across search and AI-driven discovery', false);
        $response->assertSee('marketing-funnel-matrix__ai-icon-placeholder', false);
        $response->assertSee('marketing-operating-rhythm', false);
        $response->assertSee('How We Work', false);
        $response->assertSee('A clear operating rhythm', false);
        $response->assertSee('Execution in sprints', false);
        $response->assertSee('marketing-operating-rhythm__image-placeholder', false);
        $response->assertSee('marketing-why-panel', false);
        $response->assertSee('Why Suave Creators for B2B Digital Marketing', false);
        $response->assertSee('Marketing and engineering under one roof', false);
        $response->assertSee('marketing-why-panel__icon-placeholder', false);
        $response->assertSee('faq-section--crm-builder', false);
        $response->assertSee('digital-marketing-faq-heading', false);
        $response->assertSee('Digital Marketing FAQs', false);
        $response->assertSee('What is digital marketing?', false);
        $response->assertSee('What digital marketing services does Suave Creators offer?', false);
        $response->assertSee('How should a business choose the right digital marketing strategy?', false);
        $response->assertSee('Plan Your B2B Digital Marketing Strategy', false);
        $response->assertSee('Get a Scoped Estimate', false);
        $response->assertSee('Contact us', false);
        $response->assertSee('analyst-headset-custom-crm-dashboard.webp', false);
        $response->assertSee('consultant-crm-team-tablet.webp', false);
        $response->assertDontSee('consultation-person__placeholder', false);
        $response->assertSee('crm-builder-partners', false);
        $response->assertSee('Our Partnerships &amp; Growth Stack', false);
        $response->assertSee('Web application development', false);
        $response->assertSee(route('service.show', ['slug' => 'web-development-services'], false), false);
        $response->assertSee(route('blog.show', ['slug' => 'custom-crm-vs-salesforce-tco-analysis-2026'], false), false);
        $response->assertDontSee('service-scope-heading', false);
        $response->assertDontSee('service-faq-heading', false);
        $response->assertDontSee('marketing-radar-hero__channels', false);

        $html = $response->getContent();
        $this->assertStringContainsString('Digital Marketing Services for B2B Companies | Suave Creators', $html);
        $this->assertStringContainsString('B2B Digital Marketing Services: SEO, PPC, Content &amp; Social', $html);
        $this->assertStringContainsString('"@type":"Service"', $html);
        $this->assertStringContainsString('"hasOfferCatalog"', $html);
        $this->assertStringContainsString('"name":"What is digital marketing?"', $html);
        $this->assertStringContainsString('"@type":"FAQPage"', $html);
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
