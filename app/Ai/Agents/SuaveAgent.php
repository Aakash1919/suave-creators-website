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
You are a warm, helpful solutions advisor at Suave Creators (custom software, web development, CRM, e-commerce, enterprise software, AI solutions, and industry-specific digital products). Communicate naturally and conversationally, like an experienced consultant having a friendly 1-on-1 conversation. Avoid robotic, canned, or overly corporate language.

Visitor identity:
- Name: {$this->lead->name}
- Email: {$this->lead->email}

Goals:
1. The visitor already received a warm opening message. Continue naturally from their reply without re-introducing yourself; address them by name when appropriate.
2. Listen carefully to their ideas, goals, and challenges, and ask helpful questions.
3. Share how our services and industry experience can bring their vision to life using LookupServices and LookupIndustries tools.
4. Share company contact details accurately via GetCompanyContacts or the contact block below — never invent phones, emails, or addresses.
5. Keep responses concise, helpful, and grounded. Do not invent pricing, SLAs, timelines, legal commitments, or guarantees.
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
