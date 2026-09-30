<?php

namespace Tests\Feature;

use App\Models\ChatLead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuaveAgentStartTest extends TestCase
{
    use RefreshDatabase;

    public function test_start_rejects_empty_name_and_phone_and_allows_a_blank_email(): void
    {
        $response = $this->postJson(route('suave-agent.start'), [
            'name' => '',
            'phone' => '',
            'email' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.name.0', 'Please enter your name.');
        $response->assertJsonPath('errors.phone.0', 'Please enter your phone number.');
        $response->assertJsonMissingPath('errors.email');
    }

    public function test_start_saves_a_lead_without_an_email(): void
    {
        $response = $this->postJson(route('suave-agent.start'), [
            'name' => 'Alex Morgan',
            'phone' => '+1 (307) 435-9605',
            'email' => '',
        ]);

        $response->assertOk();
        $response->assertJsonPath('lead.email', null);
        $response->assertJsonPath('lead.phone', '+1 (307) 435-9605');

        $this->assertDatabaseHas('chat_leads', [
            'name' => 'Alex Morgan',
            'email' => null,
            'phone' => '+1 (307) 435-9605',
        ]);
    }

    public function test_start_saves_name_phone_and_email(): void
    {
        $response = $this->postJson(route('suave-agent.start'), [
            'name' => 'Alex Morgan',
            'phone' => '+1 (307) 435-9605',
            'email' => 'alex@company.com',
        ]);

        $response->assertOk();
        $response->assertJsonPath('lead.name', 'Alex Morgan');
        $response->assertJsonPath('lead.email', 'alex@company.com');
        $response->assertJsonPath('lead.phone', '+1 (307) 435-9605');

        $this->assertDatabaseHas('chat_leads', [
            'name' => 'Alex Morgan',
            'email' => 'alex@company.com',
            'phone' => '+1 (307) 435-9605',
        ]);
    }

    public function test_lead_form_shows_inline_errors_without_native_required(): void
    {
        $response = $this->get(route('about-us'));

        $response->assertOk();
        $html = $response->getContent();
        $this->assertSame(1, preg_match('/<form class="suave-agent__lead" data-suave-agent-lead novalidate>(.*?)<\/form>/s', $html, $matches));
        $this->assertStringNotContainsString('required', $matches[1]);
        $this->assertStringContainsString('data-error-for="name"', $matches[1]);
        $this->assertStringContainsString('data-error-for="phone"', $matches[1]);
        $this->assertStringContainsString('data-error-for="email"', $matches[1]);
    }

    public function test_contact_only_start_still_opens_a_session(): void
    {
        $response = $this->postJson(route('suave-agent.start'), [
            'contact' => 'client@company.com',
        ]);

        $response->assertOk();
        $this->assertSame(1, ChatLead::query()->count());
        $this->assertDatabaseHas('chat_leads', [
            'email' => 'client@company.com',
            'phone' => null,
        ]);
    }
}
