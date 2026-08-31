<?php

namespace Tests\Feature;

use App\Jobs\SyncWebsiteLeadToCrmJob;
use App\Models\ChatLead;
use App\Models\ContactRequest;
use App\Services\CrmLeadSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class WebsiteCrmLeadSyncTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.crm_leads.webhook_url' => 'https://tenant.example.test/api/webhooks/website/leads',
            'services.crm_leads.webhook_token' => 'test-crm-token',
        ]);

        Http::fake([
            'https://tenant.example.test/api/webhooks/website/leads' => Http::response(['success' => true], 200),
        ]);
    }

    public function test_final_contact_submit_posts_saved_fields_to_crm_without_a_job(): void
    {
        Queue::fake();

        $this->postJson(route('contact-us.store'), [
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'service' => 'web-development',
            'message' => 'We need a new marketing site for our CRM launch.',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ])->assertOk();

        $contact = ContactRequest::query()->first();
        $this->assertNotNull($contact);

        Queue::assertNothingPushed();
        $this->assertFalse(class_exists(SyncWebsiteLeadToCrmJob::class));

        Http::assertSent(function ($request) use ($contact): bool {
            return $request->url() === 'https://tenant.example.test/api/webhooks/website/leads'
                && $request->hasHeader('Authorization', 'Bearer test-crm-token')
                && $request['source'] === CrmLeadSyncService::SOURCE_CONTACT
                && $request['source_id'] === (string) $contact->id
                && $request['name'] === 'Jane Cooper'
                && $request['email'] === 'jane@company.com'
                && $request['phone'] === '+91 90000 00000'
                && $request['service'] === 'Web Development'
                && $request['message'] === 'We need a new marketing site for our CRM launch.'
                && $request['messages'] === [];
        });
        Http::assertSentCount(1);
    }

    public function test_draft_and_honeypot_do_not_post_to_crm(): void
    {
        $this->postJson(route('contact-us.draft'), [
            'draft_token' => '11111111-1111-4111-8111-111111111111',
            'name' => 'Jane Cooper',
        ])->assertOk();

        $this->postJson(route('contact-us.store'), [
            'name' => 'Bot',
            'email' => 'bot@spam.test',
            'phone' => '+91 90000 00000',
            'service' => 'web-development',
            'message' => 'Spam message that should be ignored by honeypot.',
            'website' => 'https://spam.test',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ])->assertOk();

        Http::assertNothingSent();
    }

    public function test_quick_consultation_posts_chat_payload_not_contact(): void
    {
        $response = $this->postJson(route('consultation.store'), [
            'contact' => 'jane@company.com',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ]);

        $response->assertOk();
        $leadUuid = $response->json('chat_session.lead_uuid');
        $this->assertNotEmpty($leadUuid);

        $consultation = ContactRequest::query()->first();
        $this->assertNotNull($consultation);

        Http::assertSent(function ($request) use ($leadUuid, $consultation): bool {
            return $request['source'] === CrmLeadSyncService::SOURCE_CHAT
                && $request['source_id'] === $leadUuid
                && $request['name'] === 'Jane'
                && $request['email'] === 'jane@company.com'
                && $request['phone'] === null
                && $request['messages'][0]['side'] === 'theirs'
                && $request['messages'][0]['body'] === $consultation->message;
        });

        Http::assertNotSent(function ($request): bool {
            return ($request['source'] ?? null) === CrmLeadSyncService::SOURCE_CONTACT;
        });
    }

    public function test_contact_form_still_saves_when_crm_webhook_fails(): void
    {
        Http::fake([
            'https://tenant.example.test/api/webhooks/website/leads' => Http::response(['error' => 'unavailable'], 503),
        ]);

        $this->postJson(route('contact-us.store'), [
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'service' => 'web-development',
            'message' => 'We need a new marketing site.',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ])->assertOk();

        $this->assertSame(1, ContactRequest::query()->count());
    }

    public function test_chat_payload_maps_phone_stored_in_email_field(): void
    {
        $lead = ChatLead::query()->create([
            'name' => 'Guest',
            'email' => '+1 555 0199',
            'session_token' => ChatLead::hashSessionToken('plain'),
        ]);

        app(CrmLeadSyncService::class)->syncChat($lead, 'Free consultation requested');

        Http::assertSent(function ($request): bool {
            return $request['source'] === 'chat'
                && $request['email'] === null
                && $request['phone'] === '+1 555 0199'
                && $request['messages'][0]['side'] === 'theirs'
                && $request['messages'][0]['body'] === 'Free consultation requested';
        });
    }
}
