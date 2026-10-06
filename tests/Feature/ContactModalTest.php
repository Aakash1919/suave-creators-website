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
        $response->assertSee('window.openContactModal', false);
        $response->assertSee('data-phone-field', false);
        $response->assertSee('data-phone-field-input', false);
        $response->assertSee('data-phone-field-value', false);
        $response->assertSee('suave-phone-field', false);
        $response->assertSee('intlTelInput', false);
        $response->assertSee('Email <span class="text-red-500">*</span>', false);
        $response->assertDontSee('Business Email', false);
        $response->assertDontSee('Company Name', false);
        $response->assertSee('Project Details / Message', false);
        $response->assertSee('name="message"', false);
        $response->assertSee('hidden lg:flex flex-col', false);
    }

    public function test_about_page_hero_schedule_call_links_to_contact_page_and_consultation_triggers_modal(): void
    {
        $response = $this->get(route('about-us'));

        $response->assertOk();
        $response->assertSee('Schedule a discovery call');
        $response->assertSee('href="'.route('contact-us', absolute: false).'#contact-id"', false);
        $response->assertDontSee('calendar.google.com', false);

        $response->assertSee('Schedule a Call');
        $response->assertSee('data-open-contact-modal', false);
    }

    public function test_home_page_consultation_section_button_triggers_contact_modal(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Get a Scoped Estimate');
        $response->assertDontSee('Send My Request', false);
        $response->assertSee('production platforms delivered since 2021', false);
        $response->assertSee('name="twitter:description" content="Custom CRM, ERP and web apps by senior developers. 100% code ownership, 2-week sprints."', false);
        $response->assertSee('data-open-contact-modal', false);
        $response->assertSee('data-service="custom-software"', false);
        $response->assertDontSee('Claim Free Architecture Scoping Session', false);
        $response->assertDontSee('Book Direct via Google Calendar →', false);
    }

    public function test_home_page_get_started_button_triggers_contact_modal(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Get a Scoped Estimate');
        $content = $response->getContent();
        $this->assertMatchesRegularExpression(
            '/<a[^>]*href=["\']#contact-modal["\'][^>]*data-open-contact-modal[^>]*>[\s\S]*?Get a Scoped Estimate[\s\S]*?<\/a>/i',
            $content
        );
    }

    public function test_contact_modal_has_no_throttle_rate_limit_on_repeated_submissions(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $payload = [
                'name' => "User {$i}",
                'email' => "user{$i}@example.com",
                'phone' => "+1 555 010 {$i}",
                'company' => "Company {$i}",
                'service' => 'web-development',
                'message' => "Testing rapid submissions number {$i} to verify no rate limit.",
                'form_started_at' => time() - 10,
                '_ajax' => '1',
            ];

            $response = $this->postJson(route('contact-us.store'), $payload);
            $this->assertNotEquals(429, $response->getStatusCode(), "Request {$i} should not be throttled (429).");
            $response->assertOk();
        }
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

    public function test_contact_modal_submission_with_custom_message_succeeds(): void
    {
        $payload = [
            'name' => 'Sarah Connor',
            'email' => 'sarah@skynet-defense.com',
            'phone' => '+1 415 555 2671',
            'company' => 'Cyberdyne Systems',
            'service' => 'ai-solutions',
            'message' => 'We need an enterprise AI search portal integrated with our internal databases.',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
        ];

        $response = $this->postJson(route('contact-us.store'), $payload);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'The request has been sent successfully.',
        ]);

        $saved = ContactRequest::query()->where('email', 'sarah@skynet-defense.com')->first();
        $this->assertNotNull($saved);
        $this->assertStringContainsString('enterprise AI search portal', $saved->message);
        $this->assertStringContainsString('Cyberdyne Systems', $saved->message);
    }

    public function test_contact_modal_draft_save_includes_company_and_message(): void
    {
        $token = '33333333-3333-4333-8333-333333333333';

        $response = $this->postJson(route('contact-us.draft'), [
            'draft_token' => $token,
            'name' => 'Alex Morgan',
            'company' => 'Innovate Corp',
            'service' => 'ai-solutions',
            'message' => 'Drafting a new project inquiry for AI systems',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $this->assertDatabaseCount('contact_requests', 1);
        $saved = ContactRequest::query()->where('draft_token', $token)->first();
        $this->assertNotNull($saved);
        $this->assertEquals('Alex Morgan', $saved->name);
        $this->assertStringContainsString('Innovate Corp', (string) $saved->message);
        $this->assertStringContainsString('Drafting a new project inquiry', (string) $saved->message);
    }

    public function test_thank_you_page_renders_successfully(): void
    {
        $response = $this->get(route('thank-you'));

        $response->assertSee('Thank You!');
        $response->assertSee('Your Request Has Been Received');
        $response->assertSee('We appreciate you reaching out to Suave Creators');
        $response->assertSee('Back to Home');
        $response->assertSee(route('home'));
        $response->assertDontSee('What Happens Next?');
        $response->assertDontSee('Explore While You Wait');
    }

    public function test_contact_modal_submission_returns_thank_you_redirect_in_json(): void
    {
        $payload = [
            'name' => 'Elena Rostova',
            'email' => 'elena@enterprise.org',
            'phone' => '+44 7700 900077',
            'service' => 'enterprise-software',
            'message' => 'Need architectural review of distributed cloud services.',
            'form_started_at' => time() - 10,
            '_ajax' => '1',
            '_redirect' => route('thank-you'),
        ];

        $response = $this->postJson(route('contact-us.store'), $payload);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('redirect', route('thank-you'));
    }

    public function test_contact_page_submission_does_not_redirect_to_thank_you(): void
    {
        $payload = [
            'name' => 'Marcus Vance',
            'email' => 'marcus@vancecapital.com',
            'phone' => '+1 212 555 0199',
            'service' => 'custom-crm',
            'message' => 'Migrating financial CRM to custom Laravel solution.',
            'form_started_at' => time() - 10,
        ];

        $response = $this->post(route('contact-us.store'), $payload);

        $response->assertRedirect(route('contact-us').'#contact-id');
    }

    public function test_homepage_request_form_accepts_budget_without_a_phone(): void
    {
        $response = $this->postJson(route('contact-us.store'), [
            'name' => 'Jordan Lee',
            'email' => 'jordan@example.com',
            'company' => 'Northwind',
            'service' => 'hire-developers',
            'budget' => 'Monthly team',
            'form_started_at' => time() - 10,
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $stored = ContactRequest::query()->where('email', 'jordan@example.com')->first();
        $this->assertNotNull($stored);
        $this->assertSame('hire-developers', $stored->service);
        $this->assertNull($stored->phone);
        $this->assertStringContainsString('Budget: Monthly team', (string) $stored->message);
        $this->assertStringContainsString('Need: Hire developers', (string) $stored->message);
    }

    public function test_contact_form_still_requires_a_phone_without_a_budget(): void
    {
        $response = $this->postJson(route('contact-us.store'), [
            'name' => 'Jordan Lee',
            'email' => 'jordan@example.com',
            'service' => 'custom-software',
            'message' => 'Need a scoped estimate for a customer portal.',
            'form_started_at' => time() - 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('phone');
    }

    public function test_homepage_final_section_offers_estimate_and_hire_dialogs(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Ready to Build or Scale', false);
        $response->assertSee('Your Product?', false);
        $response->assertSee('id="project-estimate-dialog"', false);
        $response->assertSee('id="hire-developers-dialog"', false);
        $html = $response->getContent();
        $footerAt = strpos($html, 'site-footer');
        $estimateAt = strpos($html, 'id="project-estimate-dialog"');
        $hireAt = strpos($html, 'id="hire-developers-dialog"');
        $this->assertNotFalse($footerAt);
        $this->assertGreaterThan($footerAt, $estimateAt);
        $this->assertGreaterThan($estimateAt, $hireAt);
        $response->assertSee('data-inquiry-dialog-open="project-estimate-dialog"', false);
        $response->assertSee('data-inquiry-dialog-open="hire-developers-dialog"', false);
        $response->assertSee('Get an Estimate', false);
        $response->assertSee('Get My Estimate', false);
        $response->assertSee('Hire the Right Developers', false);
        $response->assertSee('Request Developer Options', false);
    }

    public function test_project_estimate_dialog_accepts_a_request_without_a_phone(): void
    {
        $response = $this->postJson(route('contact-us.store'), [
            'name' => 'Avery Chen',
            'email' => 'avery@example.com',
            'company' => 'Northwind',
            'service' => 'custom-crm',
            'budget' => 'Not sure yet',
            'message' => 'We need a CRM that replaces our spreadsheet pipeline.',
            'inquiry' => 'project-estimate',
            'form_started_at' => time() - 10,
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $stored = ContactRequest::query()->where('email', 'avery@example.com')->first();
        $this->assertNotNull($stored);
        $this->assertSame('custom-crm', $stored->service);
        $this->assertNull($stored->phone);
        $this->assertStringContainsString('spreadsheet pipeline', (string) $stored->message);
    }

    public function test_hire_dialog_accepts_a_request_without_a_phone_or_budget(): void
    {
        $response = $this->postJson(route('contact-us.store'), [
            'name' => 'Sam Patel',
            'email' => 'sam@example.com',
            'company' => 'Lumen',
            'service' => 'hire-developers',
            'inquiry' => 'hire-developers',
            'expertise' => 'Laravel / PHP',
            'support_type' => 'Dedicated Developer',
            'start_when' => 'Within 1–2 weeks',
            'message' => 'We need a senior Laravel developer for our billing portal.',
            'form_started_at' => time() - 10,
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $stored = ContactRequest::query()->where('email', 'sam@example.com')->first();
        $this->assertNotNull($stored);
        $this->assertSame('hire-developers', $stored->service);
        $this->assertNull($stored->phone);
        $this->assertStringContainsString('Expertise: Laravel / PHP', (string) $stored->message);
        $this->assertStringContainsString('Support: Dedicated Developer', (string) $stored->message);
        $this->assertStringContainsString('Start: Within 1–2 weeks', (string) $stored->message);
    }

    public function test_hire_dialog_requires_expertise_and_support_type(): void
    {
        $response = $this->postJson(route('contact-us.store'), [
            'name' => 'Sam Patel',
            'email' => 'sam@example.com',
            'service' => 'hire-developers',
            'inquiry' => 'hire-developers',
            'message' => 'We need a senior Laravel developer for our billing portal.',
            'form_started_at' => time() - 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['expertise', 'support_type']);
    }

    public function test_homepage_dialogs_reject_a_too_short_name_and_company(): void
    {
        $response = $this->postJson(route('contact-us.store'), [
            'name' => 'S',
            'email' => 'sam@example.com',
            'company' => 'L',
            'service' => 'hire-developers',
            'inquiry' => 'hire-developers',
            'expertise' => 'Laravel / PHP',
            'support_type' => 'Dedicated Developer',
            'message' => 'We need a senior Laravel developer for our billing portal.',
            'form_started_at' => time() - 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'company']);
    }

    public function test_homepage_dialogs_require_company_and_a_selected_dropdown(): void
    {
        $estimate = $this->postJson(route('contact-us.store'), [
            'name' => 'Avery Chen',
            'email' => 'avery@example.com',
            'service' => 'custom-crm',
            'message' => 'We need a CRM that replaces our spreadsheet pipeline.',
            'inquiry' => 'project-estimate',
            'form_started_at' => time() - 10,
        ]);

        $estimate->assertStatus(422);
        $estimate->assertJsonValidationErrors(['company', 'budget']);

        $hire = $this->postJson(route('contact-us.store'), [
            'name' => 'Sam Patel',
            'email' => 'sam@example.com',
            'service' => 'hire-developers',
            'inquiry' => 'hire-developers',
            'expertise' => 'Laravel / PHP',
            'support_type' => 'Dedicated Developer',
            'message' => 'We need a senior Laravel developer for our billing portal.',
            'form_started_at' => time() - 10,
        ]);

        $hire->assertStatus(422);
        $hire->assertJsonValidationErrors(['company', 'start_when']);
    }
}
