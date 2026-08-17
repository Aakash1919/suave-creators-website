<?php

namespace Tests\Feature;

use App\Support\Frontend\ServiceSupport;
use Tests\TestCase;

class EnterpriseSoftwareSeoTest extends TestCase
{
    public function test_enterprise_software_page_targets_definition_examples_and_management_intent(): void
    {
        $service = ServiceSupport::service('enterprise-software-solutions');
        $faqs = array_column($service['faqs'] ?? [], 'question');
        $pageText = implode(' ', [
            $service['pageTitle'] ?? '',
            $service['pageDescription'] ?? '',
            $service['ogTitle'] ?? '',
            $service['ogDescription'] ?? '',
            ...($service['bodyParagraphs'] ?? []),
            ...array_column($service['faqs'] ?? [], 'answer'),
        ]);

        $this->assertSame(
            'Enterprise Software Solutions, Examples & Management | Suave Creators',
            $service['pageTitle'] ?? '',
        );
        $this->assertStringContainsString(
            'Enterprise software solutions, definition, examples, and management support for growing teams.',
            $service['pageDescription'] ?? '',
        );
        $this->assertContains('What is enterprise software?', $faqs);
        $this->assertContains('What are examples of enterprise software?', $faqs);
        $this->assertContains('How does enterprise software management help operations?', $faqs);
        $this->assertStringContainsString(
            'ERP, CRM, HR management, inventory and order management, analytics dashboards, workflow automation, and system integrations',
            $pageText,
        );
        $this->assertNotSame('Ready to Build Your Website? Let’s Get Started!', $service['ctaTitle'] ?? '');
        $this->assertStringNotContainsString('your website should do more than just exist online', $service['finalDescription'] ?? '');
    }
}
