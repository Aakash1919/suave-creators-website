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
    }

    public function test_final_contact_submit_queues_crm_sync(): void
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

        Queue::assertPushed(SyncWebsiteLeadToCrmJob::class, function (SyncWebsiteLeadToCrmJob $job): bool {
            return $job->source === CrmLeadSyncService::SOURCE_CONTACT
                && $job->sourceId === (string) ContactRequest::query()->value('id');
        });
    }

    public function test_draft_and_honeypot_do_not_queue_crm_sync(): void
    {
        Queue::fake();

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

        Queue::assertNothingPushed();
    }

    public function test_quick_consultation_queues_chat_not_contact(): void
    {
        Queue::fake();

        $response = $this->postJson(route('consultation.store'), [
            'contact' => 'jane@company.com',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ]);

        $response->assertOk();
        $leadUuid = $response->json('chat_session.lead_uuid');
        $this->assertNotEmpty($leadUuid);

        Queue::assertPushed(SyncWebsiteLeadToCrmJob::class, function (SyncWebsiteLeadToCrmJob $job) use ($leadUuid): bool {
            return $job->source === CrmLeadSyncService::SOURCE_CHAT
                && $job->sourceId === $leadUuid
                && filled($job->firstInboundBody);
        });

        Queue::assertNotPushed(SyncWebsiteLeadToCrmJob::class, function (SyncWebsiteLeadToCrmJob $job): bool {
            return $job->source === CrmLeadSyncService::SOURCE_CONTACT;
        });
    }

    public function test_job_posts_contact_payload_to_crm(): void
    {
        Http::fake([
            'https://tenant.example.test/api/webhooks/website/leads' => Http::response(['success' => true], 200),
        ]);

        $contact = ContactRequest::query()->create([
            'name' => 'Jane Cooper',
            'email' => 'jane@company.com',
            'phone' => '+91 90000 00000',
            'service' => 'web-development',
            'message' => 'We need a new marketing site.',
            'status' => ContactRequest::STATUS_NEW,
        ]);

        (new SyncWebsiteLeadToCrmJob(CrmLeadSyncService::SOURCE_CONTACT, (string) $contact->id))
            ->handle(app(CrmLeadSyncService::class));

        Http::assertSent(function ($request) use ($contact): bool {
            return $request->url() === 'https://tenant.example.test/api/webhooks/website/leads'
                && $request->hasHeader('Authorization', 'Bearer test-crm-token')
                && $request['source'] === 'contact'
                && $request['source_id'] === (string) $contact->id
                && $request['email'] === 'jane@company.com'
                && $request['service'] === 'Web Development'
                && $request['messages'] === [];
        });
    }

    public function test_chat_payload_maps_phone_stored_in_email_field(): void
    {
        Http::fake([
            'https://tenant.example.test/api/webhooks/website/leads' => Http::response(['success' => true], 200),
        ]);

        $lead = ChatLead::query()->create([
            'name' => 'Guest',
            'email' => '+1 555 0199',
            'session_token' => ChatLead::hashSessionToken('plain'),
        ]);

        (new SyncWebsiteLeadToCrmJob(CrmLeadSyncService::SOURCE_CHAT, $lead->uuid, 'Free consultation requested'))
            ->handle(app(CrmLeadSyncService::class));

        Http::assertSent(function ($request): bool {
            return $request['source'] === 'chat'
                && $request['email'] === null
                && $request['phone'] === '+1 555 0199'
                && $request['messages'][0]['side'] === 'theirs'
                && $request['messages'][0]['body'] === 'Free consultation requested';
        });
    }
}
