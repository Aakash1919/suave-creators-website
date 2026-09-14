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

    public function test_frontend_layout_uses_vite_tailwind_not_cdn(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertDontSee('https://cdn.tailwindcss.com', false);
        $response->assertDontSee('resources/js/app.js', false);
    }

    public function test_footer_desktop_grid_uses_full_width_columns(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertSee('lg:col-span-3', false);
        $response->assertSee('lg:col-span-9', false);
        $response->assertDontSee('lg:col-span-1', false);
    }

    public function test_contact_form_success_tracks_generate_lead_event(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertSee('generate_lead', false);
        $response->assertSee('contact_form', false);
        $response->assertSee('lead_tracked', false);
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
