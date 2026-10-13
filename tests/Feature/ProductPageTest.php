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
        $response->assertSee('Sign up free →', false);

        // Breadcrumb
        $response->assertSee('aria-label="Breadcrumb"', false);
        $response->assertSee('>Suave CRM<', false);

        // Hero section
        $response->assertSee('Free CRM · Sales + Projects + HR + Invoicing', false);
        $response->assertSee('product-hero__headline-wrap', false);
        $response->assertSee('Free CRM for Agencies and', false);
        $response->assertSee('Startups: Sales, Projects, HR and', false);
        $response->assertSee('Invoicing', false);
        $response->assertSee('in One App', false);
        $response->assertSee('Suave AI analyses', false);
        $response->assertSee('Cold emails sent', false);
        $response->assertSee('Stop paying for five tools.', false);
        $response->assertSee('<strong>Suave CRM</strong>', false);
        $response->assertSee('<strong>sales pipeline</strong>', false);
        $response->assertSee('placeholder="Work email"', false);
        $response->assertSee('Sign Up Free', false);
        $response->assertSee('Prefer a walkthrough first? Book a demo →', false);
        $response->assertSee('Free for growing teams', false);
        $response->assertSee('No payment needed', false);
        $response->assertSee('Works worldwide', false);
        $response->assertSee('product-hero__banner', false);
        $response->assertSee('Our team responds faster, works smarter, and closes more deals.', false);
        $response->assertSee('Amit Rana', false);
        $response->assertSee('Turbo Trans Corporation', false);
        $response->assertSee('product-hero__proof-avatar', false);
        $response->assertSee('>AR<', false);
        $response->assertDontSee('product-hero__chips', false);
        $response->assertDontSee('Secure &amp; Reliable', false);

        // At a glance
        $response->assertSee('at a Glance', false);
        $response->assertSee('The essentials your team needs to sell, deliver, track time and get paid', false);
        $response->assertSee('Suave Creators, a US-registered software company with an engineering center in India', false);
        $response->assertSee('product-glance__grid', false);
        $response->assertSee('product-glance__card', false);

        // What you save / add-ons comparison
        $response->assertSee('Included free', false);
        $response->assertSee('One Free CRM', false);
        $response->assertSee('Instead of Five Subscriptions', false);
        $response->assertSee('Most growing teams pay separately for a', false);
        $response->assertSee('What teams usually pay for', false);
        $response->assertSee('A project management subscription', false);
        $response->assertSee('product-compare__job-icon', false);
        $response->assertSee('Set up your workspace in minutes - Sign up Free', false);

        // Sales
        $response->assertSee('Free sales CRM with', false);
        $response->assertSee('AI Lead Scoring', false);
        $response->assertSee('Win more clients without a sales-ops team.', false);
        $response->assertSee('AI lead qualification', false);
        $response->assertSee('Visual pipeline', false);
        $response->assertSee('Company discovery', false);
        $response->assertSee('Suave AI briefings', false);
        $response->assertSee('Email from your own Gmail', false);
        $response->assertSee('Start with the free Sales CRM →', false);
        $response->assertSee('product-module__body--split', false);
        $response->assertSee('product-module-pipeline', false);
        $response->assertSee('Opportunities', false);
        $response->assertSee('Frame Labs', false);

        // Projects, time and billing, team and HR
        $response->assertSee('Free project management', false);
        $response->assertSee('product-module--showcase', false);
        $response->assertSee('product-module__showcase-card', false);
        $response->assertSee('product-module__showcase-image-placeholder', false);
        $response->assertSee('My tasks every morning', false);
        $response->assertSee('and invoicing software', false);
        $response->assertSee('id="time-billing"', false);
        $response->assertSee('product-module--dark', false);
        $response->assertSee('product-module--cols-3', false);
        $response->assertSee('Timesheets', false);
        $response->assertSee('Log hours against projects and clients.', false);
        $response->assertSee('Targets and analytics', false);
        $response->assertSee('Sales goals, team progress and project dashboards, live.', false);
        $response->assertSee('Free attendance and HR software,', false);
        $response->assertSee('Working vs. worked hours, attendance percentage and efficiency per person.', false);
        $response->assertSee('product-module--cards', false);
        $response->assertSee('product-module__card--tone-green', false);
        $response->assertSee('Attendance calendar', false);

        // AI Assistant section
        $response->assertSee('AI across your workspace', false);
        $response->assertSee('Ask Suave: the AI assistant', false);
        $response->assertSee('that runs through your CRM', false);
        $response->assertSee('Ask Suave from any screen for answers about your leads, projects and tasks.', false);
        $response->assertSee('A daily brief for everyone', false);
        $response->assertSee('AI where it saves time', false);
        $response->assertSee('Included at no extra cost', false);
        $response->assertSee('product-ask-suave', false);
        $response->assertSee('What needs my attention today?', false);
        $response->assertSee('3 priorities for this morning', false);
        $response->assertSee('Call Nova systems - high-intent lead', false);

        // Who it's for, getting started, why teams switch
        $response->assertSee('id="who-its-for"', false);
        $response->assertSee('product-module--audience', false);
        $response->assertSee('Built for how agencies and startups', false);
        $response->assertSee('actually work', false);
        $response->assertSee('IT services and software development companies', false);
        $response->assertSee('product-module__audience-image-placeholder', false);
        $response->assertSee('Explore solution →', false);
        $response->assertSee('Start using Suave CRM', false);
        $response->assertSee('for free', false);
        $response->assertSee('A clean workspace in minutes, not a month-long software implementation.', false);
        $response->assertSee('Create your Workspace →', false);
        $response->assertSee('product-module--steps', false);
        $response->assertSee('Sign up with your work email', false);
        $response->assertSee('Want help setting up?', false);
        $response->assertSee('Book a Demo →', false);
        $response->assertSee('Why growing teams choose', false);
        $response->assertSee('AI included, not upsold', false);

        // Privacy
        $response->assertSee('product-data-privacy__badge', false);
        $response->assertSee('Is my data safe in Suave CRM?', false);
        $response->assertSee('Google API Services User Data Policy (Limited Use)', false);

        // Testimonial
        $response->assertSee('id="product-testimonials-title"', false);
        $response->assertSee('The Suave Sales CRM streamlined our entire sales process.', false);
        $response->assertSee('Managing Director, Turbo Trans Corporation', false);
        $response->assertSee('See more client results', false);
        $response->assertDontSee('Suave Creators Team', false);

        // Sticky mobile bar
        $response->assertSee('Free CRM for your team', false);

        // Removed content stays off the page
        $response->assertDontSee('Link Gmail with Google', false);
        $response->assertDontSee('Your data is yours. We just keep it safe.', false);
        $response->assertDontSee('Want Similar Results?', false);

        // FAQ section
        $response->assertSee('id="product-faq-heading"', false);
        $response->assertSee('FAQ', false);
        $response->assertSee('Is Suave CRM really free?', false);
        $response->assertSee('What&#039;s included in the free CRM?', false);
        $response->assertSee('What is the best free CRM for small agencies?', false);
        $response->assertSee('Does Suave CRM include attendance and HR?', false);

        // Final CTA
        $response->assertSee('Run Your Company Free', false);
        $response->assertSee('Run your whole company', false);
        $response->assertSee('from one free CRM', false);
        $response->assertSee('Sales, projects, timesheets, HR and invoicing, with AI built in. Free for small and mid-size companies, anywhere in the world.', false);
        $response->assertSee('Prefer a walkthrough? Book a demo →', false);
        $response->assertSee('id="product-final-email"', false);
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
        $response->assertSee('name="application-name" content="Suave CRM"', false);
        $response->assertSee('property="og:title" content="One Free CRM Instead of Five Subscriptions | Suave CRM"', false);
        $response->assertSee('property="og:description" content="Sales pipeline, projects, timesheets, attendance, HR and invoicing with AI built in. Free for small and mid-size companies, worldwide."', false);
        $response->assertSee('name="twitter:title" content="Free All-in-One CRM for Agencies &amp; Startups | Suave CRM"', false);

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
