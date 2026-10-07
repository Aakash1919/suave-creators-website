<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_loads_and_displays_free_all_in_one_crm_content(): void
    {
        $response = $this->get(route('product', absolute: false));

        $response->assertOk();

        // Announcement bar
        $response->assertSee('Free CRM for agencies and startups:', false);
        $response->assertSee('sales, projects, HR and invoicing in one app.', false);
        $response->assertSee('Sign up free', false);

        // Hero section
        $response->assertSee('Free CRM · Sales + Projects + HR + Invoicing', false);
        $response->assertSee('Free CRM for', false);
        $response->assertSee('Agencies &amp; Startups', false);
        $response->assertSee('Sales, Projects, HR &amp; Invoicing', false);
        $response->assertSee('in One App', false);
        $response->assertSee('Stop paying for five tools. Suave CRM gives small and mid-size teams a free sales pipeline, project management, timesheets, attendance, HR and invoicing, with an AI assistant built in.', false);
        $response->assertSee('Sign Up Free', false);
        $response->assertSee('Book a Demo', false);
        $response->assertSee('Free for small and mid-size companies &middot; No payment needed &middot; Works in any browser, worldwide', false);

        // Chips
        $response->assertSee('AI Assistant', false);
        $response->assertSee('Sales &amp; Pipeline', false);
        $response->assertSee('Projects &amp; HR', false);
        $response->assertSee('Secure &amp; Reliable', false);

        // Sales section
        $response->assertSee('Free Sales CRM', false);
        $response->assertSee('with AI Lead Scoring', false);
        $response->assertSee('Win more clients without a sales-ops team.', false);
        $response->assertSee('AI Lead Qualification', false);
        $response->assertSee('Visual Pipeline', false);
        $response->assertSee('Company Discovery', false);
        $response->assertSee('S-Mail &amp; AI Briefings', false);

        // What you save / Add-ons section
        $response->assertSee('Included Free', false);
        $response->assertSee('One Free CRM', false);
        $response->assertSee('Instead of Five Subscriptions', false);
        $response->assertSee('Most growing teams pay separately for a CRM, a project tool, time tracking, an HR or attendance app and invoicing software', false);
        $response->assertSee('What teams usually pay for', false);
        $response->assertSee('A project management subscription', false);
        $response->assertSee('Included free', false);
        $response->assertSee('Set up your workspace in minutes &mdash; Sign Up Free', false);

        // At a glance
        $response->assertSee('at a glance', false);
        $response->assertSee('Suave Creators, a US-registered software company with an engineering center in India', false);

        // Projects, time and billing, team and HR
        $response->assertSee('Free project management', false);
        $response->assertSee('My tasks every morning', false);
        $response->assertSee('and invoicing software', false);
        $response->assertSee('Free attendance and HR software,', false);
        $response->assertSee('Working vs. worked hours, attendance percentage and efficiency per person.', false);

        // AI Assistant section
        $response->assertSee('Ask Suave: the AI assistant', false);
        $response->assertSee('that runs through your CRM', false);
        $response->assertSee('Lead scoring, prospect briefings, follow-up drafts and task help, at no extra cost.', false);

        // Who it's for, getting started, why teams switch
        $response->assertSee('agencies and startups actually work', false);
        $response->assertSee('IT services and software development companies', false);
        $response->assertSee('Suave CRM for free', false);
        $response->assertSee('Want help setting up?', false);
        $response->assertSee('Why growing teams choose', false);
        $response->assertSee('AI included, not upsold', false);

        // Data & Privacy section
        $response->assertSee('Data &amp; Privacy', false);
        $response->assertSee('Is my data safe in Suave CRM?', false);
        $response->assertSee('Google API Services User Data Policy (Limited Use)', false);

        // Testimonial
        $response->assertSee('id="product-testimonials-title"', false);
        $response->assertSee('What our clients say', false);
        $response->assertSee('Managing Director, Turbo Trans Corporation', false);
        $response->assertSee('Suave Creators Team', false);
        $response->assertSee('See more client results', false);

        // Sticky mobile bar
        $response->assertSee('Free CRM for your team', false);

        // Removed content stays off the page
        $response->assertDontSee('Link Gmail with Google', false);
        $response->assertDontSee('Your data is yours. We just keep it safe.', false);
        $response->assertDontSee('Want Similar Results?', false);

        // FAQ section
        $response->assertSee('faq-section--align', false);
        $response->assertSee('assets/background/technology-section-bg.png', false);
        $response->assertSee('assets/media/diverse-team-data-meeting.webp', false);
        $response->assertSee('Have questions about our CRM?', false);
        $response->assertSee('Frequently Asked Questions: Free CRM, Pricing &amp; Data Safety', false);
        $response->assertSee('Get Free Consultation', false);
        $response->assertSee('Is Suave CRM really free?', false);
        $response->assertSee('What&#039;s included in the free CRM?', false);
        $response->assertSee('What is the best free CRM for small agencies?', false);
        $response->assertSee('Does Suave CRM include attendance and HR?', false);

        // Final CTA
        $response->assertSee('Run Your Company Free', false);
        $response->assertSee('Run your whole company', false);
        $response->assertSee('from one free CRM', false);
        $response->assertSee('Sales, projects, timesheets, HR and invoicing, with AI built in. Free for small and mid-size companies, anywhere in the world.', false);
    }

    public function test_legacy_ai_powered_outreach_crm_redirects_to_free_all_in_one_crm(): void
    {
        $response = $this->get('/ai-powered-outreach-crm');

        $response->assertRedirect('/free-all-in-one-crm');

        $followed = $this->followingRedirects()->get('/ai-powered-outreach-crm');
        $followed->assertOk();
        $followed->assertSee('Free All-in-One CRM for Agencies &amp; Startups | Suave CRM', false);
    }

    public function test_product_page_has_correct_seo_and_json_ld(): void
    {
        $response = $this->get(route('product', absolute: false));

        $response->assertOk();

        // SEO Title & Description
        $response->assertSee('<title>Free All-in-One CRM for Agencies &amp; Startups | Suave CRM</title>', false);
        $response->assertSee('name="description" content="Free CRM with sales pipeline, projects, timesheets, HR and invoicing in one app. Built for agencies and startups worldwide. Sign up free, no payment needed."', false);
        $response->assertSee('property="og:title" content="One Free CRM Instead of Five Subscriptions | Suave CRM"', false);
        $response->assertSee('property="og:description" content="Sales pipeline, projects, timesheets, attendance, HR and invoicing with AI built in. Free for small and mid-size companies, worldwide."', false);

        // JSON-LD SoftwareApplication
        $response->assertSee('"@type":"SoftwareApplication"', false);
        $response->assertSee('"name":"Suave CRM"', false);
        $response->assertSee('"isAccessibleForFree":true', false);
        $response->assertSee('"price":"0"', false);
        $response->assertSee('"priceCurrency":"USD"', false);

        // JSON-LD FAQPage
        $response->assertSee('"@type":"FAQPage"', false);
        $response->assertSee('Is Suave CRM really free?', false);
    }
}
