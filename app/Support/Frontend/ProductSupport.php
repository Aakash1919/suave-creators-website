<?php

namespace App\Support\Frontend;

class ProductSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900 product-site product-layout',
            'mainClass' => 'site-main product-layout-main',
            'useHeroBackground' => true,
            'heroBackgroundImage' => '',
            'contactHref' => ContactSupport::demoHref(),
            'demoHref' => ContactSupport::demoHref(),
            'heroBadge' => 'Free CRM · Sales + Projects + HR + Invoicing',
            'heroBackground' => asset('assets/product/product-top-sections-bg.webp'),
            'heroBannerTiles' => self::heroBannerTiles(),
            'heroChips' => self::heroChips(),
            'heroBanner' => [
                'src' => asset('assets/product/hero_banner.gif'),
                'backSrc' => asset('assets/product/hero_banner_back.webp'),
                'alt' => 'Professional executive with animated blue digital energy streaks for Suave CRM platform',
                'backAlt' => 'Soft blue screen blend glow layer behind Suave CRM product hero banner',
            ],
            'glance' => self::glance(),
            'howItWorksSteps' => self::howItWorksSteps(),
            'savings' => self::savings(),
            'featureSections' => self::featureSections(),
            'dataPrivacy' => self::dataPrivacy(),
            'testimonials' => self::testimonials(),
            'salesCta' => self::salesCta(),
            'faqs' => self::faqs(),
            'pricing' => self::pricing(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected static function heroBannerTiles(): array
    {
        return [
            [
                'position' => 'top-left',
                'type' => 'lead',
                'src' => asset('assets/product/hero-banner-new-lead-tile.png'),
                'alt' => 'New lead notification tile for Devid Warner in Suave CRM platform',
            ],
            [
                'position' => 'bottom-left',
                'type' => 'follow-up',
                'title' => 'Suave AI Daily Brief',
                'description' => '3 high-priority leads to call and 2 client deliverables due today.',
            ],
            [
                'position' => 'top-right',
                'type' => 'deal-won',
                'src' => asset('assets/product/hero-banner-deal-won-tile.png'),
                'alt' => 'Deal won notification tile for Albert Flores website redesign in Suave CRM',
            ],
            [
                'position' => 'bottom-right',
                'type' => 'companies',
                'src' => asset('assets/product/hero-banner-companies-discovered-tile.webp'),
                'alt' => 'Companies discovered stat tile showing 248 leads from map and list in Suave CRM',
            ],
        ];
    }

    /**
     * @return array<int, array{icon: string, label: string, alt: string}>
     */
    protected static function heroChips(): array
    {
        return [
            [
                'icon' => asset('assets/product/ai_assistant.png'),
                'label' => 'AI Assistant',
                'alt' => 'AI assistant icon for Suave CRM',
            ],
            [
                'icon' => asset('assets/product/smart_automation.png'),
                'label' => 'Sales & Pipeline',
                'alt' => 'Sales and pipeline management icon for Suave CRM',
            ],
            [
                'icon' => asset('assets/product/real_time_analysis.png'),
                'label' => 'Projects & HR',
                'alt' => 'Projects, attendance, and HR icon for Suave CRM',
            ],
            [
                'icon' => asset('assets/product/hero-chip-secure-reliable.png'),
                'label' => 'Secure & Reliable',
                'alt' => 'Security and reliability icon for Suave CRM',
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, value: string}>
     */
    protected static function glance(): array
    {
        return [
            ['label' => 'Price', 'value' => 'Free for small and mid-size companies'],
            ['label' => "What's included", 'value' => 'Sales pipeline, AI lead scoring, projects and tasks, timesheets, attendance and HR, invoicing, team messaging, documents and an AI assistant'],
            ['label' => 'Best for', 'value' => 'IT agencies, software development companies, web and digital agencies, startups and growing teams'],
            ['label' => 'Platform', 'value' => 'Web app; works in any modern browser'],
            ['label' => 'Availability', 'value' => 'Worldwide'],
            ['label' => 'Email', 'value' => 'Send from your own Gmail account (optional connection)'],
            ['label' => 'Getting started', 'value' => 'Sign up with your work email and start; demo available on request'],
            ['label' => 'Made by', 'value' => 'Suave Creators, a US-registered software company with an engineering center in India'],
        ];
    }

    /**
     * @return array<int, array{job: string, usual: string}>
     */
    protected static function savings(): array
    {
        return [
            ['job' => 'Sales pipeline', 'usual' => 'A per-seat CRM'],
            ['job' => 'Projects and tasks', 'usual' => 'A project management subscription'],
            ['job' => 'Time tracking', 'usual' => 'A time-tracking app'],
            ['job' => 'Attendance and HR', 'usual' => 'An HR or attendance tool'],
            ['job' => 'Invoicing', 'usual' => 'An invoicing tool'],
        ];
    }

    /**
     * Light feature sections rendered in order between "What you save" and Data & Privacy.
     *
     * @return array<int, array<string, mixed>>
     */
    protected static function featureSections(): array
    {
        return [
            [
                'id' => 'projects',
                'badge' => 'Projects',
                'title' => 'Free project management',
                'titleAccent' => 'for client work',
                'subtitle' => 'When a deal closes, the work starts in the same app. No hand-off, no copy-paste into another tool.',
                'columns' => 4,
                'items' => [
                    ['icon' => 'fa-layer-group', 'title' => 'Projects & Tasks', 'description' => 'Kanban and list views, owners, due dates and an AI assistant for overdue and assigned work.'],
                    ['icon' => 'fa-clock', 'title' => 'My tasks every morning', 'description' => "Each person sees what's due today, filtered by status, the moment they log in."],
                    ['icon' => 'fa-laptop-file', 'title' => 'Documents', 'description' => 'Proposals, contracts and files stay on the client record.'],
                    ['icon' => 'fa-message', 'title' => 'Messenger', 'description' => 'Discuss a deal or project in context, not in a separate chat app.'],
                ],
            ],
            [
                'id' => 'time-billing',
                'badge' => 'Time and Billing',
                'title' => 'Free timesheet',
                'titleAccent' => 'and invoicing software',
                'subtitle' => 'Track every billable hour and turn it into an invoice without exporting a spreadsheet.',
                'columns' => 3,
                'items' => [
                    ['icon' => 'fa-clock-four', 'title' => 'Timesheets', 'description' => 'Log hours against projects and clients.'],
                    ['icon' => 'fa-paper-plane', 'title' => 'Invoicing', 'description' => 'Create and send invoices from won deals and logged time.'],
                    ['icon' => 'fa-magnifying-glass-chart', 'title' => 'Targets and analytics', 'description' => 'Sales goals, team progress and project dashboards, live.'],
                ],
            ],
            [
                'id' => 'team-hr',
                'badge' => 'Team and HR',
                'title' => 'Free attendance and HR software,',
                'titleAccent' => 'built in',
                'subtitle' => "Know who's working, how the month is going and where time goes, without a separate HR system.",
                'columns' => 4,
                'items' => [
                    ['icon' => 'fa-clock', 'title' => 'Punch in and out', 'description' => "Punch in and out from the dashboard, with a live timer and each person's shift timing."],
                    ['icon' => 'fa-user-group', 'title' => 'Attendance calendar', 'description' => 'Attendance calendar showing present days, leave and holidays.'],
                    ['icon' => 'fa-magnifying-glass-chart', 'title' => 'Monthly insights', 'description' => 'Working vs. worked hours, attendance percentage and efficiency per person.'],
                    ['icon' => 'fa-users', 'title' => 'HR profiles', 'description' => 'Department, designation, shift and joining date for the whole team.'],
                ],
            ],
            [
                'id' => 'business-works',
                'badge' => 'AI',
                'title' => 'Ask Suave: the AI assistant',
                'titleAccent' => 'that runs through your CRM',
                'subtitle' => '',
                'columns' => 3,
                'items' => [
                    ['icon' => 'fa-message', 'title' => 'Ask from any screen', 'description' => 'Ask Suave from any screen for answers about your leads, projects and tasks.'],
                    ['icon' => 'fa-bolt', 'title' => 'A daily brief', 'description' => 'A daily brief on every dashboard, so each person knows where to start.'],
                    ['icon' => 'fa-robot', 'title' => 'AI everywhere it saves time', 'description' => 'Lead scoring, prospect briefings, follow-up drafts and task help, at no extra cost.'],
                ],
                'cta' => 'Sign Up Free',
            ],
            [
                'id' => 'who-its-for',
                'badge' => "Who It's For",
                'title' => 'The free CRM built for how',
                'titleAccent' => 'agencies and startups actually work',
                'subtitle' => '',
                'columns' => 4,
                'items' => [
                    ['icon' => 'fa-laptop-code', 'title' => 'IT services and software development companies', 'description' => 'Track deals, run client projects, log billable hours and invoice, all against the same client record.'],
                    ['icon' => 'fa-pen-ruler', 'title' => 'Web, design and digital agencies', 'description' => "Juggle many clients at once: see every project's tasks, hours and invoices without switching tools."],
                    ['icon' => 'fa-rocket', 'title' => 'Startups', 'description' => 'Get a CRM, project tracker and HR basics on day one, for free, and keep them as the team grows.'],
                    ['icon' => 'fa-users', 'title' => 'Growing small and mid-size teams', 'description' => 'Replace spreadsheets and scattered apps with one system everyone actually logs into.'],
                ],
            ],
            [
                'id' => 'getting-started',
                'badge' => 'Getting Started',
                'title' => 'How to start using',
                'titleAccent' => 'Suave CRM for free',
                'subtitle' => '',
                'columns' => 3,
                'numbered' => true,
                'items' => [
                    ['title' => 'Sign up with your work email', 'description' => 'No payment needed.'],
                    ['title' => 'Invite your team', 'description' => 'Switch on the modules you need: sales, projects, timesheets, HR or invoicing.'],
                    ['title' => 'Add your first leads and projects', 'description' => 'Let Ask Suave guide the rest.'],
                ],
                'note' => 'Want help setting up?',
                'noteLink' => "Book a demo and we'll walk your team through it.",
                'cta' => 'Sign Up Free',
            ],
            [
                'id' => 'why-suave',
                'badge' => 'Why Teams Switch',
                'title' => 'Why growing teams choose',
                'titleAccent' => 'Suave CRM',
                'subtitle' => '',
                'columns' => 3,
                'items' => [
                    ['icon' => 'fa-check', 'title' => 'Free for small and mid-size companies', 'description' => 'No per-seat bill that grows with every hire.'],
                    ['icon' => 'fa-layer-group', 'title' => 'One login for the whole company', 'description' => 'Sales, delivery, HR and billing share the same data.'],
                    ['icon' => 'fa-robot', 'title' => 'AI included, not upsold', 'description' => 'Lead scoring, briefings, follow-ups and task help come with the free CRM.'],
                    ['icon' => 'fa-globe', 'title' => 'Works anywhere', 'description' => 'A web app available worldwide, in any modern browser.'],
                    ['icon' => 'fa-shield-halved', 'title' => 'Your data stays yours', 'description' => 'We never sell it, and Gmail access is optional and revocable.'],
                    ['icon' => 'fa-code', 'title' => 'Built by engineers', 'description' => 'Suave CRM is made by Suave Creators, who also build custom CRMs for companies that need a fully owned system.'],
                ],
            ],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, description: string, alt: string}>
     */
    protected static function howItWorksSteps(): array
    {
        return [
            [
                'icon' => asset('assets/product/how-it-works-ai-qualification-icon.svg'),
                'title' => 'AI Lead Qualification',
                'description' => 'Leads from forms, ads, your website, calls, and email are scored automatically by AI.',
                'alt' => 'AI qualification icon for Suave CRM lead scoring',
            ],
            [
                'icon' => asset('assets/product/how-it-works-manage-pipeline-icon.svg'),
                'title' => 'Visual Pipeline',
                'description' => 'Track every deal, conversation, activity, and next step on one clear, drag-and-drop board.',
                'alt' => 'Manage pipeline icon for Suave CRM visual board',
            ],
            [
                'icon' => asset('assets/product/how-it-works-capture-lead-icon.svg'),
                'title' => 'Company Discovery',
                'description' => 'Find target companies that fit your ideal client profile by map or curated list view.',
                'alt' => 'Company discovery icon for Suave CRM prospect identification',
            ],
            [
                'icon' => asset('assets/product/how-it-works-close-deals-icon.svg'),
                'title' => 'S-Mail & AI Briefings',
                'description' => 'Receive AI prospect briefs, compose smart drafts, and send cold emails from your own Gmail with open tracking.',
                'alt' => 'S-Mail and Suave AI briefing icon for outreach automation',
            ],
        ];
    }

    /**
     * @return array{
     *     badge: string,
     *     title: string,
     *     description: string,
     *     links: array<int, array{label: string, href: string, external: bool}>,
     *     background: string,
     *     graphic: array{src: string, alt: string}
     * }
     */
    protected static function dataPrivacy(): array
    {
        return [
            'badge' => 'Data & Privacy',
            'title' => 'Is my data safe in Suave CRM?',
            'description' => 'Connecting Gmail is optional. You sign in with Google OAuth, Google\'s consent screen shows exactly what S-Mail requests, and you can disconnect anytime in Suave CRM or revoke access in your Google Account. We access only the Gmail data you authorize, and we do not sell Google user data, use it for ads, or train generalized AI or ML models on it.',
            'background' => asset('assets/product/data-privacy-section-bg.webp'),
            'links' => [
                [
                    'label' => 'Privacy Policy',
                    'href' => route('privacy-policy'),
                    'external' => false,
                ],
                [
                    'label' => 'Terms & Conditions',
                    'href' => route('terms-and-conditions'),
                    'external' => false,
                ],
                [
                    'label' => 'Google API Services User Data Policy (Limited Use)',
                    'href' => 'https://developers.google.com/terms/api-services-user-data-policy',
                    'external' => true,
                ],
            ],
            'graphic' => [
                'src' => asset('assets/product/data-privacy-security-infographic.webp'),
                'alt' => 'Suave CRM data privacy security infographic showing CRM modules protected by a central shield',
            ],
        ];
    }

    /**
     * Review node for the SoftwareApplication JSON-LD.
     *
     * @return array{quote: string, name: string, role: string, company: string}
     */
    protected static function testimonial(): array
    {
        return [
            'quote' => 'The Suave Sales CRM streamlined our entire sales process. Our team responds faster, works smarter, and closes more deals.',
            'name' => 'Amit Rana',
            'role' => 'Managing Director',
            'company' => 'Turbo Trans Corporation',
        ];
    }

    /**
     * @return array<int, array{quote: string, name: string, role: string}>
     */
    protected static function testimonials(): array
    {
        $testimonial = self::testimonial();

        return [
            [
                'quote' => $testimonial['quote'],
                'name' => $testimonial['name'],
                'role' => $testimonial['role'].', '.$testimonial['company'],
            ],
            [
                'quote' => 'We run our own projects, billing, and team on Suave CRM every day. One workspace replaced the stack of tools we used to juggle.',
                'name' => 'Suave Creators Team',
                'role' => 'Product Team, Suave Creators',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function salesCta(): array
    {
        return [
            'badge' => 'Run Your Company Free',
            'titleLead' => 'Run your whole company ',
            'titleBuild' => '',
            'titleAccent' => 'from one free CRM',
            'description' => 'Sales, projects, timesheets, HR and invoicing, with AI built in. Free for small and mid-size companies, anywhere in the world.',
            'background' => asset('assets/product/data-privacy-section-bg.webp'),
            'button' => 'Sign Up Free',
            'dealCard' => [
                'title' => 'New Deal',
                'company' => 'Acme Corporation',
                'amount' => '$74.25',
                'category' => 'Digital Marketing',
                'avatar' => [
                    'src' => asset('assets/product/product-sales-cta-deal-avatar.svg'),
                    'alt' => 'New deal contact avatar for Suave CRM demo preview card',
                ],
                'chart' => [
                    'src' => asset('assets/product/new-deal-graph.png'),
                    'alt' => 'New deal revenue growth chart for Suave CRM preview card',
                ],
            ],
            'insightCard' => [
                'title' => 'AI Insight',
                'description' => 'This lead is highly likely to convert based on its behavior and engagement.',
                'icon' => [
                    'src' => asset('assets/product/product-sales-cta-ai-insight-icon.svg'),
                    'alt' => 'AI insight icon for Suave CRM lead conversion preview card',
                ],
            ],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    public static function faqs(): array
    {
        return [
            [
                'question' => 'Is Suave CRM really free?',
                'answer' => 'Yes. Suave CRM is free for small and mid-size companies. Sign up with your work email and start using it; no payment is needed.',
            ],
            [
                'question' => "What's included in the free CRM?",
                'answer' => 'The free CRM includes a sales pipeline with AI lead scoring, company discovery and AI briefings, email from your own Gmail, projects and tasks, timesheets, attendance and HR, invoicing, team messaging, documents and the Ask Suave AI assistant.',
            ],
            [
                'question' => 'What is the best free CRM for small agencies?',
                'answer' => "The best free CRM for a small agency covers more than sales: it should also handle projects, time tracking and invoicing, so client work doesn't live in separate tools. Suave CRM includes all of these free for small and mid-size companies.",
            ],
            [
                'question' => 'Who is Suave CRM for?',
                'answer' => 'Suave CRM is built for IT agencies, software development companies, web and digital agencies, startups and other small and mid-size teams that sell and deliver client work.',
            ],
            [
                'question' => 'How do I sign up for Suave CRM?',
                'answer' => 'Sign up with your work email, create your workspace and invite your team. You can add leads, projects and team members right away and switch on only the modules you need.',
            ],
            [
                'question' => 'Can I get a demo before signing up?',
                'answer' => 'Yes. Book a demo and a member of our team will walk you through Suave CRM and help you choose the modules that fit your company.',
            ],
            [
                'question' => 'Is Suave CRM available in my country?',
                'answer' => 'Yes. Suave CRM is a web application available worldwide, so teams in any region can sign up and use it in a browser.',
            ],
            [
                'question' => 'Does Suave CRM include project management and timesheets?',
                'answer' => 'Yes. A won deal becomes a project with tasks, owners and due dates, and your team logs hours against projects and clients, then invoices from that time, all in the same app.',
            ],
            [
                'question' => 'Does Suave CRM include attendance and HR?',
                'answer' => 'Yes. Team members punch in and out from their dashboard, and Suave CRM tracks attendance, leave, holidays, shift timings, worked hours, attendance percentage and efficiency, alongside HR profiles.',
            ],
            [
                'question' => 'Is my data safe in Suave CRM?',
                'answer' => 'We never sell your data. Connecting Gmail is optional, we access only the Gmail data you authorize, and you can disconnect or revoke access at any time. We do not use Google user data for ads or to train generalized AI models.',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function pricing(): array
    {
        return [
            'badge' => 'Pricing',
            'titlePrefix' => 'Simple,',
            'titleAccent' => 'Transparent Pricing',
            'subtitle' => 'Choose the perfect plan to grow your sales with confidence.',
            'plans' => self::pricingPlans(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected static function pricingPlans(): array
    {
        return [
            [
                'name' => 'Free',
                'tagline' => 'Free forever for 10 users',
                'price' => '$0',
                'period' => '/month',
                'audience' => 'Perfect for individuals and small teams getting started.',
                'features' => [
                    'Up to 5 Users',
                    '100 Leads',
                    'Contact Management',
                    'Basic Sales Pipeline',
                    'AI Lead Scoring (Limited)',
                    'Email Support',
                ],
                'cta' => 'Get it now',
                'featured' => false,
                'custom' => false,
                'tone' => 'blue',
                'icon' => asset('assets/product/free.png'),
                'alt' => 'Free plan icon for Suave AI sales CRM pricing tier',
            ],
            [
                'name' => 'Starter',
                'tagline' => 'Everything you need to get started',
                'price' => '$7.94',
                'period' => '/month',
                'audience' => 'Ideal for growing teams that need essential sales tools.',
                'features' => [
                    'Up to 10 Users',
                    'Unlimited Leads',
                    'Contact Management',
                    'Sales Pipeline',
                    'Reports & Analytics',
                    'Email Support',
                ],
                'cta' => 'Start free trial',
                'featured' => false,
                'custom' => false,
                'tone' => 'purple',
                'icon' => asset('assets/product/starter.png'),
                'alt' => 'Starter plan icon for Suave AI CRM essential sales tools pricing',
            ],
            [
                'name' => 'Growth',
                'tagline' => 'Align multiple teams',
                'price' => '$14.54',
                'period' => '/month',
                'audience' => 'Advanced automation and AI for scaling sales teams.',
                'features' => [
                    'Up to 25 Users',
                    'Everything in Starter',
                    'AI Assistant',
                    'Workflow Automation',
                    'Advanced Reports',
                    'Team Collaboration',
                    'Priority Support',
                ],
                'cta' => 'Start free trial',
                'featured' => true,
                'custom' => false,
                'tone' => 'teal',
                'icon' => asset('assets/product/growth.png'),
                'alt' => 'Growth plan icon for Suave AI powered sales CRM automation pricing',
            ],
            [
                'name' => 'Enterprise',
                'tagline' => 'Analytics built for enterprise scale',
                'price' => 'Custom',
                'period' => '',
                'audience' => 'Tailored solutions for large organizations with advanced requirements.',
                'features' => [
                    'Unlimited Users',
                    'Everything in Growth',
                    'Custom Workflows',
                    'API Access',
                    'Dedicated Account Manager',
                    'Enterprise Security',
                    'SLA & Onboarding',
                ],
                'cta' => 'Contact Sales',
                'featured' => false,
                'custom' => true,
                'tone' => 'orange',
                'icon' => asset('assets/product/expertise.png'),
                'alt' => 'Enterprise plan icon for Suave AI CRM custom organization pricing',
            ],
        ];
    }

    /**
     * SEO structured-data overrides for the product page (JSON-LD graph nodes).
     *
     * @return array{seoJsonLdGraph: array<int, array<string, mixed>>, seoJsonLdWebpageAbout: string, seoFaqs: array<int, array{question: string, answer: string}>}
     */
    public static function seoStructuredData(): array
    {
        $pageUrl = rtrim(route('product'), '/');
        $softwareId = $pageUrl.'/#software';

        return [
            'seoJsonLdGraph' => [self::jsonLdSoftwareApplication($pageUrl, $softwareId)],
            'seoJsonLdWebpageAbout' => $softwareId,
            'seoFaqs' => self::faqs(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function jsonLdSoftwareApplication(string $pageUrl, string $softwareId): array
    {
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');
        $testimonial = self::testimonial();
        $name = (string) (config('seo.pages.product.json_ld_name') ?? 'Suave CRM');
        $description = (string) (config('seo.pages.product.json_ld_description')
            ?? config('seo.pages.product.description')
            ?? 'Suave CRM is a free all-in-one CRM for agencies, startups and small and mid-size companies, combining a sales pipeline with AI lead scoring, projects and tasks, timesheets, attendance and HR, invoicing and the Ask Suave AI assistant.');

        $featureList = [
            'Sales pipeline with AI lead scoring',
            'Company discovery and Suave AI prospect briefings',
            'Email from your own Gmail with S-Mail, AI drafts and open tracking',
            'Projects & Tasks with an AI task assistant',
            'Timesheets',
            'Invoicing from won deals and logged hours',
            'Punch in and out, shifts and attendance calendar',
            'Monthly worked hours, attendance percentage and efficiency',
            'HR profiles',
            'Targets, analytics, documents, messenger and email management',
            'Ask Suave AI assistant and daily brief',
        ];

        return array_filter([
            '@type' => 'SoftwareApplication',
            '@id' => $softwareId,
            'name' => $name,
            'alternateName' => ['The Suave App', 'Suave Sales CRM'],
            'description' => $description,
            'url' => $pageUrl,
            'applicationCategory' => 'BusinessApplication',
            'applicationSubCategory' => 'Free CRM with project management, timesheets, HR and invoicing',
            'operatingSystem' => 'Web browser',
            'isAccessibleForFree' => true,
            'image' => asset('assets/product/product-hero-banner.webp'),
            'screenshot' => asset('assets/product/product-hero-banner.webp'),
            'publisher' => [
                '@id' => $baseUrl.'/#organization',
            ],
            'creator' => [
                '@id' => $baseUrl.'/#organization',
            ],
            'audience' => [
                '@type' => 'BusinessAudience',
                'audienceType' => 'IT agencies, software development companies, digital agencies, startups and other small and mid-size companies',
            ],
            'featureList' => $featureList,
            'offers' => [
                '@type' => 'Offer',
                'name' => 'Free for small and mid-size companies',
                'price' => '0',
                'priceCurrency' => 'USD',
                'areaServed' => 'Worldwide',
                'url' => $pageUrl,
            ],
            'review' => [
                '@type' => 'Review',
                '@id' => $pageUrl.'/#review',
                'author' => [
                    '@type' => 'Person',
                    'name' => (string) $testimonial['name'],
                    'jobTitle' => (string) $testimonial['role'],
                    'worksFor' => [
                        '@type' => 'Organization',
                        'name' => (string) $testimonial['company'],
                    ],
                ],
                'reviewBody' => (string) $testimonial['quote'],
                'itemReviewed' => [
                    '@id' => $softwareId,
                ],
            ],
        ], static fn (mixed $value): bool => $value !== null && $value !== '');
    }
}
