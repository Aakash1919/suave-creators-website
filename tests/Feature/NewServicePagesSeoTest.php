<?php

namespace Tests\Feature;

use App\Support\Frontend\ServiceSupport;
use App\View\Components\Frontend\IndustriesSection;
use App\View\Components\Frontend\ThreeCardSection;
use App\View\Components\Layouts\Footer;
use Tests\TestCase;

class NewServicePagesSeoTest extends TestCase
{
    public function test_ui_ux_design_page_has_targeted_title_description_and_faqs(): void
    {
        $service = ServiceSupport::service('ui-ux-design-services');
        $faqs = array_column($service['faqs'] ?? [], 'question');

        $this->assertSame(
            'UI/UX Design Services That Convert | Suave Creators',
            $service['pageTitle'] ?? '',
        );
        $this->assertStringContainsString('UI/UX design services', $service['pageDescription'] ?? '');
        $this->assertLessThanOrEqual(60, strlen((string) ($service['pageTitle'] ?? '')));
        $this->assertLessThanOrEqual(160, strlen((string) ($service['pageDescription'] ?? '')));
        $this->assertContains('What are UI/UX design services?', $faqs);
        $this->assertContains('What is the difference between UI and UX design?', $faqs);
        $this->assertCount(6, $service['faqs'] ?? []);
    }

    public function test_ai_solutions_page_has_targeted_title_description_and_faqs(): void
    {
        $service = ServiceSupport::service('ai-solutions');
        $faqs = array_column($service['faqs'] ?? [], 'question');

        $this->assertSame(
            'AI Solutions & AI Software Development | Suave Creators',
            $service['pageTitle'] ?? '',
        );
        $this->assertStringContainsString('Custom AI solutions', $service['pageDescription'] ?? '');
        $this->assertLessThanOrEqual(60, strlen((string) ($service['pageTitle'] ?? '')));
        $this->assertLessThanOrEqual(160, strlen((string) ($service['pageDescription'] ?? '')));
        $this->assertContains('What are AI solutions for business?', $faqs);
        $this->assertContains('Which AI solutions do you offer?', $faqs);
        $this->assertCount(6, $service['faqs'] ?? []);
    }

    public function test_homepage_and_footer_link_new_services_and_industries(): void
    {
        $this->assertContains('ui-ux-design-services', ServiceSupport::SLUGS);
        $this->assertContains('ai-solutions', ServiceSupport::SLUGS);

        $serviceHrefs = array_column((new ThreeCardSection)->items, 'href');
        $this->assertContains(route('service.show', ['slug' => 'web-development-services']), $serviceHrefs);
        $this->assertContains(route('service.show', ['slug' => 'ui-ux-design-services']), $serviceHrefs);
        $this->assertContains(route('service.show', ['slug' => 'ai-solutions']), $serviceHrefs);

        $industryHrefs = array_column((new IndustriesSection)->cards, 'href');
        $this->assertContains(route('industry.show', ['slug' => 'healthcare']), $industryHrefs);
        $this->assertContains(route('industry.show', ['slug' => 'education-elearning-platforms']), $industryHrefs);

        $footerLabels = array_column((new Footer)->columns['Services'], 'label');
        $this->assertContains('UI/UX Design', $footerLabels);
        $this->assertContains('AI Solutions', $footerLabels);
    }
}
