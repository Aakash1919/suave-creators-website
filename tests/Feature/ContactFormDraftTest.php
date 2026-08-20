<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormDraftTest extends TestCase
{
    use RefreshDatabase;

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
}
