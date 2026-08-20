<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormDraftTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_saves_drafts_while_typing_and_before_window_close(): void
    {
        $response = $this->get(route('contact-us'));

        $response->assertOk();
        $response->assertSee('const DRAFT_INPUT_SAVE_DELAY_MS =', false);
        $response->assertSee('function scheduleDraftSave()', false);
        $response->assertSee('input.addEventListener(\'input\', function()', false);
        $response->assertSee('scheduleDraftSave();', false);
        $response->assertSee('window.addEventListener(\'pagehide\', function()', false);
        $response->assertSee('flushDraftSave(true);', false);
    }

    public function test_blur_save_creates_one_draft_and_later_fields_update_it(): void
    {
        $token = '11111111-1111-4111-8111-111111111111';

        $first = $this->postJson(route('contact-us.draft'), [
            'draft_token' => $token,
            'name' => 'Jane Cooper',
        ]);

        $first->assertOk();
        $first->assertJsonPath('success', true);
        $first->assertJsonPath('draft_token', $token);
        $this->assertDatabaseCount('contact_requests', 1);
        $this->assertDatabaseHas('contact_requests', [
            'draft_token' => $token,
            'name' => 'Jane Cooper',
            'status' => ContactRequest::STATUS_DRAFT,
        ]);

        $second = $this->postJson(route('contact-us.draft'), [
            'draft_token' => $token,
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
        ]);

        $second->assertOk();
        $this->assertDatabaseCount('contact_requests', 1);
        $this->assertDatabaseHas('contact_requests', [
            'draft_token' => $token,
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'status' => ContactRequest::STATUS_DRAFT,
        ]);
    }

    public function test_submit_upgrades_the_draft_and_returns_the_existing_success_message(): void
    {
        $token = '22222222-2222-4222-8222-222222222222';

        $this->postJson(route('contact-us.draft'), [
            'draft_token' => $token,
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
        ])->assertOk();

        $response = $this->postJson(route('contact-us.store'), [
            'draft_token' => $token,
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'service' => 'web-development',
            'message' => 'We need a new marketing site for our CRM launch.',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'The request has been sent successfully.',
            'lead_tracked' => true,
        ]);
        $this->assertDatabaseCount('contact_requests', 1);
        $this->assertDatabaseHas('contact_requests', [
            'draft_token' => $token,
            'status' => ContactRequest::STATUS_NEW,
            'service' => 'web-development',
        ]);
    }

    public function test_honeypot_draft_is_not_stored(): void
    {
        $this->postJson(route('contact-us.draft'), [
            'draft_token' => '33333333-3333-4333-8333-333333333333',
            'name' => 'Bot',
            'website' => 'https://spam.test',
        ])->assertOk();

        $this->assertDatabaseCount('contact_requests', 0);
    }

    public function test_contact_submit_silently_ignores_ip_after_recent_lead_burst(): void
    {
        for ($i = 0; $i < 6; $i++) {
            ContactRequest::query()->create([
                'name' => 'Burst Lead '.$i,
                'email' => 'burst'.$i.'@company.com',
                'phone' => '+91 90000 0000'.$i,
                'service' => 'web-development',
                'message' => 'Existing burst lead used to trip fake lead protection.',
                'status' => ContactRequest::STATUS_NEW,
                'ip_address' => '203.0.113.10',
                'user_agent' => 'Feature test',
            ]);
        }

        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->postJson(route('contact-us.store'), [
                'name' => 'Fake Lead',
                'email' => 'fake-lead@company.com',
                'phone' => '+91 99999 99999',
                'service' => 'web-development',
                'message' => 'This should be silently ignored once the IP has a recent burst.',
                'form_started_at' => time() - 10,
                '_ajax' => '1',
            ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'The request has been sent successfully.',
            'lead_tracked' => false,
        ]);
        $this->assertDatabaseMissing('contact_requests', [
            'email' => 'fake-lead@company.com',
        ]);
        $this->assertDatabaseCount('contact_requests', 6);
    }

    public function test_repeated_same_contact_submission_does_not_create_duplicate_leads(): void
    {
        $payload = [
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'service' => 'web-development',
            'message' => 'We need a new marketing site for our CRM launch.',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ];

        $this->postJson(route('contact-us.store'), $payload)->assertOk();
        $this->postJson(route('contact-us.store'), $payload)->assertOk();

        $this->assertDatabaseCount('contact_requests', 1);
        $this->assertDatabaseHas('contact_requests', [
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'status' => ContactRequest::STATUS_NEW,
        ]);
    }
}
