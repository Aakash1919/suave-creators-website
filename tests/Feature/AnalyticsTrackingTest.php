<?php

namespace Tests\Feature;

use Tests\TestCase;

class AnalyticsTrackingTest extends TestCase
{
    public function test_frontend_layout_includes_lead_tracking_helpers(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertSee('window.suaveTrackEvent', false);
        $response->assertSee('click_call', false);
        $response->assertSee('click_email', false);
        $response->assertSee('cta_click', false);
    }

    public function test_frontend_layout_does_not_load_vite_marketing_assets(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertDontSee('/build/assets/app-', false);
        $response->assertDontSee('@vite', false);
    }

    public function test_contact_form_success_tracks_generate_lead_event(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertSee('generate_lead', false);
        $response->assertSee('contact_form', false);
        $response->assertSee("field('service')", false);
    }

    public function test_suave_agent_lead_start_tracks_chat_lead_event(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertSee('chat_lead', false);
        $response->assertSee('suave_agent', false);
    }
}
