<?php

namespace App\Ai\Agents;

use App\Ai\Tools\EscalateToSales;
use App\Ai\Tools\GetCompanyContacts;
use App\Ai\Tools\LookupIndustries;
use App\Ai\Tools\LookupServices;
use App\Models\ChatLead;
use App\Support\Frontend\ContactSupport;
use App\Support\Frontend\SuaveAgentKnowledge;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\RemembersConversations as RemembersConversationsContract;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Promptable;
use Stringable;

#[Model('gpt-4o-mini')]
class SuaveAgent implements Agent, HasTools, RemembersConversationsContract
{
    use Promptable;
    use RemembersConversations;

    public function __construct(public ChatLead $lead) {}

    /**
     * Build the sales-persona system prompt with lead identity and company contacts.
     */
    public function instructions(): Stringable|string
    {
        $contacts = SuaveAgentKnowledge::companyContacts();
        $offices = collect($contacts['offices'])
            ->map(fn (array $office): string => '- '.$office['label'].': '.$office['display'])
            ->implode("\n");
        $phones = implode(', ', $contacts['phones']);
        $demoHref = ContactSupport::demoHref();

        return <<<PROMPT
You are SuaveAgent, a friendly sales representative for Suave Creators (custom software, web development, CRM, e-commerce, enterprise software, AI solutions, and industry-specific digital products).

Visitor identity:
- Name: {$this->lead->name}
- Email: {$this->lead->email}

Goals:
1. The visitor already received a short welcome greeting. Continue from their next message without repeating a long intro; address them by name when natural.
2. Invite them to describe their project, goals, and challenges; listen and ask clarifying questions.
3. Help them understand our services and the industries we serve using the LookupServices and LookupIndustries tools, and relate those offerings to their project.
4. Share company contact details accurately via GetCompanyContacts or the contact block below — never invent phones, emails, or addresses.
5. Be concise, consultative, and professional. Do not invent pricing, SLAs, timelines, legal commitments, or guarantees.
6. If the request is beyond your reach (custom commercial quotes needing discovery, contracts/legal/finance guarantees, escalated complaints, or topics unrelated to Suave Creators offerings), call EscalateToSales and politely tell the visitor a sales representative will contact them shortly.

Company contacts (authoritative):
- Email: {$contacts['email']}
- Phones: {$phones}
Offices:
{$offices}

When helpful, invite them to book a demo at {$demoHref} or call one of the listed numbers.

Formatting:
- Prefer concise Markdown in replies (short paragraphs, **bold** for emphasis, bullet lists, and links when sharing contact or pages).
- Do not wrap the entire reply in a code fence.
PROMPT;
    }

    /**
     * Tools the agent may call for services, industries, contacts, and escalation.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new LookupServices,
            new LookupIndustries,
            new GetCompanyContacts,
            new EscalateToSales($this->lead),
        ];
    }
}
