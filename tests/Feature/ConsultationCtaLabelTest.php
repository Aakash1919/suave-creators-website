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
        foreach ([
            '/',
            '/about-us',
            '/industries',
            '/industries/healthcare',
            '/services/enterprise-software-solutions',
            '/services',
        ] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertSee('Get Free Consultation', false);
            $response->assertSee('placeholder="Enter your phone or email"', false);
            $response->assertDontSee('Start your Project', false);
        }
    }

    public function test_inline_consultation_form_saves_drafts_while_typing_and_before_window_close(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-draft-url="'.route('contact-us.draft').'"', false);
        $response->assertSee('data-consultation-draft-token', false);
        $response->assertSee('function scheduleDraftSave()', false);
        $response->assertSee('flushDraftSave(true);', false);
        $response->assertSee('window.addEventListener(\'pagehide\', function ()', false);
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
            'lead_tracked' => true,
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
            'lead_tracked' => true,
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

    public function test_quick_consultation_submit_upgrades_existing_inline_draft(): void
    {
        $token = '44444444-4444-4444-8444-444444444444';

        $this->postJson(route('contact-us.draft'), [
            'draft_token' => $token,
            'phone' => '+1 (555) 234-5678',
            'message' => 'Inline consultation started for: +1 (555) 234-5678',
        ])->assertOk();

        $this->assertDatabaseHas('contact_requests', [
            'draft_token' => $token,
            'phone' => '+1 (555) 234-5678',
            'status' => ContactRequest::STATUS_DRAFT,
        ]);

        $response = $this->postJson(route('consultation.store'), [
            'draft_token' => $token,
            'contact' => '+1 (555) 234-5678',
            'form_started_at' => time() - 10,
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('contact_requests', 1);
        $this->assertDatabaseHas('contact_requests', [
            'draft_token' => $token,
            'name' => 'Consultation Lead',
            'phone' => '+1 (555) 234-5678',
            'service' => 'Free Consultation',
            'status' => ContactRequest::STATUS_NEW,
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

    public function test_quick_consultation_silently_ignores_ip_after_recent_lead_burst(): void
    {
        for ($i = 0; $i < 6; $i++) {
            ContactRequest::query()->create([
                'name' => 'Consultation Lead',
                'email' => 'burst'.$i.'@company.com',
                'phone' => '',
                'service' => 'Free Consultation',
                'message' => 'Existing burst lead used to trip fake lead protection.',
                'status' => ContactRequest::STATUS_NEW,
                'ip_address' => '203.0.113.20',
                'user_agent' => 'Feature test',
            ]);
        }

        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.20'])
            ->postJson(route('consultation.store'), [
                'contact' => 'too-many@company.com',
                'form_started_at' => time() - 10,
            ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'lead_tracked' => false,
        ]);
        $response->assertJsonMissingPath('chat_session');
        $this->assertDatabaseMissing('contact_requests', [
            'email' => 'too-many@company.com',
        ]);
        $this->assertDatabaseCount('contact_requests', 6);
    }
}
