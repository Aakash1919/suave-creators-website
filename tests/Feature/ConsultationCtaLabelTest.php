<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationCtaLabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_primary_project_ctas_use_inline_consultation_form_with_placeholder_and_label(): void
    {
        foreach (['/', '/industries', '/services/enterprise-software-solutions', '/services'] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertSee('Get Free Consultation', false);
            $response->assertSee('placeholder="Enter your phone or email"', false);
            $response->assertDontSee('Start your Project', false);
        }
    }

    public function test_quick_consultation_submits_successfully_with_email(): void
    {
        $response = $this->postJson(route('consultation.store'), [
            'contact' => 'client@company.com',
            'form_started_at' => time() - 10,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'chat_session' => [
                'lead_uuid',
                'session_token',
                'conversation_id',
                'greeting',
                'lead' => ['name', 'email'],
            ],
        ]);

        $this->assertDatabaseHas('contact_requests', [
            'email' => 'client@company.com',
            'service' => 'Free Consultation',
        ]);
        $this->assertDatabaseHas('chat_leads', [
            'email' => 'client@company.com',
        ]);
    }

    public function test_quick_consultation_submits_successfully_with_phone(): void
    {
        $response = $this->postJson(route('consultation.store'), [
            'contact' => '+1 (555) 234-5678',
            'form_started_at' => time() - 10,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'chat_session' => [
                'lead_uuid',
                'session_token',
                'conversation_id',
                'greeting',
            ],
        ]);

        $this->assertDatabaseHas('contact_requests', [
            'phone' => '+1 (555) 234-5678',
            'service' => 'Free Consultation',
        ]);
        $this->assertDatabaseHas('chat_leads', [
            'email' => '+1 (555) 234-5678',
        ]);
    }

    public function test_quick_consultation_validates_contact_input(): void
    {
        $response = $this->postJson(route('consultation.store'), [
            'contact' => 'invalid-contact',
            'form_started_at' => time() - 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.contact.0', 'Please enter a valid phone number or email address.');
    }
}
