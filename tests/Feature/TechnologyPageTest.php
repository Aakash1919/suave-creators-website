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
        $response->assertSee('Our Technology Stack', false);
        $response->assertSee('technologies-stack__logo-placeholder', false);
        $response->assertDontSee('class="technologies-stack__logo"', false);
        $response->assertSee('Backend Development', false);
        $response->assertSee('Google&#039;s V8 engine', false);
        $response->assertSee('React, Angular and Vue.js', false);
        $response->assertSee('Mobile Application Development with', false);
        $response->assertSee('Why business choose it', false);
        $response->assertSee('Headless CMS', false);
        $response->assertSee('Shopify Plus', false);
        $response->assertSee('How These Technologies Work Together', false);
        $response->assertSee('Custom CRM + ERP', false);
        $response->assertSee('How we choose a', false);
        $response->assertSee('Build with Suave Creators', false);
        $response->assertSee('Technology FAQs', false);
        $response->assertSee('Discuss Your Technology Stack With a Solution Architect', false);
        $response->assertSee('Our Partnerships', false);
        $response->assertSee('verysoul-logo.png', false);
        $response->assertDontSee('What is a custom CRM builder?', false);
        $response->assertDontSee('turbo-trans-corporation-logo.png', false);
        $response->assertSee(route('service.show', ['slug' => 'ai-solutions']), false);
        $response->assertSee(route('case-studies'), false);
    }

    public function test_technologies_page_is_linked_from_the_header_and_footer(): void
    {
        $response = $this->get(route('home', absolute: false));

        $response->assertOk();
        $response->assertSee('href="'.route('technologies').'"', false);
        $response->assertSee('>Technology</a>', false);
        $response->assertSee('Technologies</span>', false);
    }
}
