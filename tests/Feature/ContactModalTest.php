<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_modal_is_present_on_pages_using_frontend_layout(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('id="contact-modal"', false);
        $response->assertSee('Get a Free Consultation', false);
        $response->assertSee('Service You&rsquo;re Interested In', false);
        $response->assertSee('Custom Software Development', false);
        $response->assertSee('Custom CRM Development', false);
        $response->assertSee('AI Solutions &amp; Development', false);
        $response->assertSee('Expert Guidance', false);
        $response->assertSee('Quick Response', false);
        $response->assertSee('Tailored Solutions', false);
        $response->assertSee('Complete Confidentiality', false);
        $response->assertSee('window.openContactModal', false);
    }

    public function test_contact_modal_submission_with_company_and_no_message_succeeds(): void
    {
        $payload = [
            'name' => 'Alex Morgan',
            'email' => 'alex@innovatecorp.com',
            'phone' => '+91 98765 43210',
            'company' => 'Innovate Corp',
            'service' => 'custom-software',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ];

        $response = $this->postJson(route('contact-us.store'), $payload);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'The request has been sent successfully.',
            'lead_tracked' => true,
        ]);

        $this->assertDatabaseCount('contact_requests', 1);
        $this->assertDatabaseHas('contact_requests', [
            'name' => 'Alex Morgan',
            'email' => 'alex@innovatecorp.com',
            'phone' => '+91 98765 43210',
            'service' => 'custom-software',
            'status' => ContactRequest::STATUS_NEW,
        ]);

        $saved = ContactRequest::query()->first();
        $this->assertNotNull($saved);
        $this->assertStringContainsString('Innovate Corp', $saved->message);
    }

    public function test_contact_modal_draft_save_includes_company(): void
    {
        $token = '33333333-3333-4333-8333-333333333333';

        $response = $this->postJson(route('contact-us.draft'), [
            'draft_token' => $token,
            'name' => 'Alex Morgan',
            'company' => 'Innovate Corp',
            'service' => 'ai-solutions',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $this->assertDatabaseCount('contact_requests', 1);
        $saved = ContactRequest::query()->where('draft_token', $token)->first();
        $this->assertNotNull($saved);
        $this->assertEquals('Alex Morgan', $saved->name);
        $this->assertStringContainsString('Innovate Corp', (string) $saved->message);
    }
}
