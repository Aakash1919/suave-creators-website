<?php

namespace App\Support\Frontend;

class ProductSupport
{
    public const SIGNUP_URL = 'https://the-suave.app/';

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
            'contactHref' => self::SIGNUP_URL,
            'demoHref' => ContactSupport::demoHref(),
            'signupUrl' => self::SIGNUP_URL,
            'heroBadge' => 'Free CRM · Sales + Projects + HR + Invoicing',
            'heroTitle' => 'Free CRM for Agencies and Startups: Sales, Projects, HR and Invoicing in One App',
            'heroSubtitle' => 'Stop paying for five tools. Suave CRM gives small and mid-size teams a free sales pipeline, project management, timesheets, attendance, HR and invoicing, with an AI assistant built in. Sign up and start today, from anywhere in the world.',
            'heroTrustItems' => [
                'Free for growing teams',
                'No payment needed',
                'Works worldwide',
            ],
            'heroDemoLinkLabel' => 'Prefer a walkthrough first? Book a demo →',
            'heroProof' => self::heroProof(),
            'heroFloatCards' => self::heroFloatCards(),
            'heroBackground' => asset('assets/product/product-top-sections-bg.webp'),
            'heroBannerTiles' => self::heroBannerTiles(),
            'heroBanner' => [
                'src' => asset('assets/product/hero_banner.gif'),
                'backSrc' => asset('assets/product/hero_banner_back.webp'),
                'alt' => 'Animated flowing line motion graphic for Suave CRM free all-in-one CRM hero',
                'backAlt' => 'Soft blue screen blend glow layer behind Suave CRM free all-in-one CRM hero banner',
            ],
            'glance' => self::glance(),
            'glanceSubtitle' => 'The essentials your team needs to sell, deliver, track time and get paid—without stitching together five different subscriptions.',
            'savings' => self::savings(),
            'featureSections' => self::featureSections(),
            'dataPrivacy' => self::dataPrivacy(),
            'testimonials' => self::testimonials(),
            'salesCta' => self::salesCta(),
            'faqs' => self::faqs(),
            'pricing' => self::pricing(),
            'seoTwitterTitle' => 'Free All-in-One CRM for Agencies & Startups | Suave CRM',
            'seoTwitterDescription' => 'Sales, projects, timesheets, HR and invoicing in one free app. Sign up free, no payment needed.',
            'seoOgImageAlt' => 'Suave CRM free CRM dashboard with sales pipeline, project tasks and attendance calendar',
        ];
    }

    /**
     * @return array{quote: string, name: string, role: string, company: string, initials: string}
     */
    protected static function heroProof(): array
    {
        return [
            'quote' => 'Our team responds faster, works smarter, and closes more deals.',
            'name' => 'Amit Rana',
            'role' => 'Managing Director',
            'company' => 'Turbo Trans Corporation',
            'initials' => 'AR',
        ];
    }

    /**
     * Floating metric cards flanking `.product-hero__headline-wrap`.
     *
     * @return array<int, array{side: string, label: string, value: string, meta: string, change: string}>
     */
    protected static function heroFloatCards(): array
    {
        return [
            [
                'side' => 'left',
                'label' => 'Suave AI analyses',
                'value' => '186',
                'meta' => 'Website briefings',
                'change' => '+41% SPIN prompts',
            ],
            [
                'side' => 'right',
                'label' => 'Cold emails sent',
                'value' => '94',
                'meta' => 'Via S-Mail',
                'change' => '+38% Opens tracked',
            ],
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
     * @return array<int, array{label: string, value: string, icon: string, tone: string}>
     */
    protected static function glance(): array
    {
        return [
            ['label' => 'Price', 'value' => 'Free for small and mid-size companies', 'icon' => 'fa-building', 'tone' => 'blue'],
            ['label' => "What's included", 'value' => 'Sales pipeline, AI lead scoring, projects and tasks, timesheets, attendance and HR, invoicing, team messaging, documents and an AI assistant', 'icon' => 'fa-brain', 'tone' => 'purple'],
            ['label' => 'Best for', 'value' => 'IT agencies, software development companies, web and digital agencies, startups and growing teams', 'icon' => 'fa-trophy', 'tone' => 'teal'],
            ['label' => 'Platform', 'value' => 'Web app; works in any modern browser', 'icon' => 'fa-desktop', 'tone' => 'indigo'],
            ['label' => 'Availability', 'value' => 'Worldwide', 'icon' => 'fa-globe', 'tone' => 'violet'],
            ['label' => 'Email', 'value' => 'Send from your own Gmail account (optional connection)', 'icon' => 'fa-envelope', 'tone' => 'orange'],
            ['label' => 'Getting started', 'value' => 'Sign up with your work email and start; demo available on request', 'icon' => 'fa-bolt', 'tone' => 'rose'],
            ['label' => 'Made by', 'value' => 'Suave Creators, a US-registered software company with an engineering center in India', 'icon' => 'fa-code', 'tone' => 'magenta'],
        ];
    }

    /**
     * @return array{
     *     badge: string,
     *     title: string,
     *     titleAccent: string,
     *     subtitleHtml: string,
     *     ctaLabel: string,
     *     rows: array<int, array{job: string, usual: string, icon: string}>
     * }
     */
    protected static function savings(): array
    {
        return [
            'badge' => 'Included free',
            'title' => 'One Free CRM',
            'titleAccent' => 'Instead of Five Subscriptions',
            'subtitleHtml' => 'Most growing teams pay separately for a <strong>CRM</strong>, a <strong>project tool</strong>, <strong>time tracking</strong>, an <strong>HR or attendance app</strong> and <strong>invoicing software</strong>, and many of those charge per user. When teams outgrow free plans, the bill climbs fast: <strong>HubSpot\'s Sales Hub Professional</strong>, for example, lists at <strong>USD 90</strong> per seat per month billed annually, so <strong>15 seats is USD 1,350 a month</strong> for the CRM alone. Suave CRM puts all five jobs in one app, free for small and mid-size companies.',
            'ctaLabel' => 'Set up your workspace in minutes - Sign up Free',
            'rows' => [
                ['job' => 'Sales pipeline', 'usual' => 'A per-seat CRM', 'icon' => 'fa-chart-simple'],
                ['job' => 'Projects and tasks', 'usual' => 'A project management subscription', 'icon' => 'fa-list-check'],
                ['job' => 'Time tracking', 'usual' => 'A time-tracking app', 'icon' => 'fa-clock'],
                ['job' => 'Attendance and HR', 'usual' => 'An HR or attendance tool', 'icon' => 'fa-calendar-check'],
                ['job' => 'Invoicing', 'usual' => 'An invoicing tool', 'icon' => 'fa-file-invoice'],
            ],
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
                'id' => 'how-it-works',
                'badge' => 'Sales',
                'title' => 'Free sales CRM with',
                'titleAccent' => 'AI Lead Scoring',
                'subtitle' => 'Win more clients without a sales-ops team. Every lead lands in one place, AI tells you which ones to call first, and your pipeline updates itself as deals move.',
                'items' => [
                    ['icon' => 'fa-robot', 'title' => 'AI lead qualification', 'description' => 'Leads from forms, ads, your website, calls and email are scored automatically.'],
                    ['icon' => 'fa-layer-group', 'title' => 'Visual pipeline', 'description' => 'Every deal, conversation and next step on one board.'],
                    ['icon' => 'fa-magnifying-glass-chart', 'title' => 'Company discovery', 'description' => 'Find companies that fit your ideal client profile by map or list.'],
                    ['icon' => 'fa-bolt', 'title' => 'Suave AI briefings', 'description' => 'A short brief on each prospect before you reach out.'],
                    ['icon' => 'fa-envelope', 'title' => 'Email from your own Gmail', 'description' => 'Write, send and follow up from your real address with S-Mail, with AI drafts and open tracking.'],
                ],
                'cta' => 'Start with the free Sales CRM →',
                'visual' => self::salesPipelineVisual(),
            ],
            [
                'id' => 'projects',
                'badge' => 'Projects',
                'title' => 'Free project management',
                'titleAccent' => 'for client work',
                'subtitle' => 'When a deal closes, the work starts in the same app. No hand-off, no copy-paste into another tool.',
                'layout' => 'showcase',
                'items' => [
                    [
                        'icon' => 'fa-list-check',
                        'title' => 'Projects & Tasks',
                        'description' => 'Kanban and list views, owners, due dates and an AI assistant for overdue and assigned work.',
                        'image' => '',
                        'imageAlt' => 'Suave CRM projects and tasks board for client work management',
                    ],
                    [
                        'icon' => 'fa-clock',
                        'title' => 'My tasks every morning',
                        'description' => "Each person sees what's due today, filtered by status, the moment they log in.",
                        'image' => '',
                        'imageAlt' => 'Suave CRM my tasks morning view for assigned project work',
                    ],
                    [
                        'icon' => 'fa-laptop-file',
                        'title' => 'Documents',
                        'description' => 'Proposals, contracts and files stay on the client record.',
                        'image' => '',
                        'imageAlt' => 'Suave CRM documents attached to client project records',
                    ],
                    [
                        'icon' => 'fa-message',
                        'title' => 'Messenger',
                        'description' => 'Discuss a deal or project in context, not in a separate chat app.',
                        'image' => '',
                        'imageAlt' => 'Suave CRM messenger for deal and project team discussion',
                    ],
                ],
            ],
            [
                'id' => 'time-billing',
                'layout' => 'cards',
                'theme' => 'dark',
                'backgroundImage' => asset('assets/background/technologies-backend-bg.webp'),
                'badge' => 'Time and Billing',
                'title' => 'Free timesheet',
                'titleAccent' => 'and invoicing software',
                'subtitle' => 'Track every billable hour and turn it into an invoice without exporting a spreadsheet.',
                'items' => [
                    ['icon' => 'fa-calendar-check', 'title' => 'Timesheets', 'description' => 'Log hours against projects and clients.', 'tone' => 'blue'],
                    ['icon' => 'fa-file-invoice', 'title' => 'Invoicing', 'description' => 'Create and send invoices from won deals and logged time.', 'tone' => 'blue'],
                    ['icon' => 'fa-chart-simple', 'title' => 'Targets and analytics', 'description' => 'Sales goals, team progress and project dashboards, live.', 'tone' => 'blue'],
                ],
            ],
            [
                'id' => 'team-hr',
                'layout' => 'cards',
                'badge' => 'Team and HR',
                'title' => 'Free attendance and HR software,',
                'titleAccent' => 'built in',
                'subtitle' => "Know who's working, how the month is going and where time goes, without a separate HR system.",
                'items' => [
                    ['icon' => 'fa-clock', 'title' => 'Punch in and out', 'description' => "Punch in and out from the dashboard, with a live timer and each person's shift timing.", 'tone' => 'blue'],
                    ['icon' => 'fa-calendar-check', 'title' => 'Attendance calendar', 'description' => 'Attendance calendar showing present days, leave and holidays.', 'tone' => 'purple'],
                    ['icon' => 'fa-chart-simple', 'title' => 'Monthly insights', 'description' => 'Working vs. worked hours, attendance percentage and efficiency per person.', 'tone' => 'green'],
                    ['icon' => 'fa-users', 'title' => 'HR profiles', 'description' => 'Department, designation, shift and joining date for the whole team.', 'tone' => 'violet'],
                ],
            ],
            [
                'id' => 'business-works',
                'layout' => 'ai',
                'badge' => 'AI across your workspace',
                'title' => 'Ask Suave: the AI assistant',
                'titleAccent' => 'that runs through your CRM',
                'subtitle' => 'Ask Suave from any screen for answers about your leads, projects and tasks.',
                'items' => [
                    ['icon' => 'fa-message', 'title' => 'A daily brief for everyone', 'description' => 'Know where to start the moment you log in.'],
                    ['icon' => 'fa-bolt', 'title' => 'AI where it saves time', 'description' => 'Lead scores, prospect briefings and follow-up drafts.'],
                    ['icon' => 'fa-wand-magic-sparkles', 'title' => 'Included at no extra cost', 'description' => 'No separate AI add-on or usage surprise.'],
                ],
                'cta' => 'Sign up Free',
                'visual' => self::askSuaveVisual(),
            ],
            [
                'id' => 'who-its-for',
                'layout' => 'audience',
                'theme' => 'dark',
                'backgroundImage' => asset('assets/background/technologies-backend-bg.webp'),
                'badge' => "Who It's For",
                'title' => 'Built for how agencies and startups',
                'titleAccent' => 'actually work',
                'subtitle' => 'Track every billable hour and turn it into an invoice without exporting a spreadsheet.',
                'linkLabel' => 'Explore solution →',
                'items' => [
                    [
                        'title' => 'IT services and software development companies',
                        'description' => 'Track deals, run client projects, log billable hours and invoice, all against the same client record.',
                        'image' => '',
                        'imageAlt' => 'IT services team using Suave CRM for client projects and billing',
                    ],
                    [
                        'title' => 'Web, design and digital agencies',
                        'description' => "Juggle many clients at once: see every project's tasks, hours and invoices without switching tools.",
                        'image' => '',
                        'imageAlt' => 'Digital agency designer managing multiple client projects in Suave CRM',
                    ],
                    [
                        'title' => 'Startups',
                        'description' => 'Get a CRM, project tracker and HR basics on day one, for free, and keep them as the team grows.',
                        'image' => '',
                        'imageAlt' => 'Startup team collaborating on sales and projects in Suave CRM',
                    ],
                    [
                        'title' => 'Growing small and mid-size teams',
                        'description' => 'Replace spreadsheets and scattered apps with one system everyone actually logs into.',
                        'image' => '',
                        'imageAlt' => 'Small business team meeting around Suave CRM workspace',
                    ],
                ],
            ],
            [
                'id' => 'getting-started',
                'layout' => 'steps',
                'badge' => 'Getting Started',
                'title' => 'Start using Suave CRM',
                'titleAccent' => 'for free',
                'subtitle' => 'A clean workspace in minutes, not a month-long software implementation.',
                'items' => [
                    ['icon' => 'fa-envelope', 'title' => 'Sign up with your work email', 'description' => 'No payment needed.'],
                    ['icon' => 'fa-users', 'title' => 'Invite your team', 'description' => 'Switch on sales, projects, timesheets, HR or invoicing.'],
                    ['icon' => 'fa-gears', 'title' => 'Add your first leads and projects', 'description' => 'Let Ask Suave guide the rest.'],
                ],
                'cta' => 'Create your Workspace →',
                'help' => [
                    'title' => 'Want help setting up?',
                    'body' => "Book a demo and we'll walk your team through it.",
                    'linkLabel' => 'Book a Demo →',
                ],
            ],
            [
                'id' => 'why-suave',
                'badge' => 'Why Teams Switch',
                'title' => 'Why growing teams choose',
                'titleAccent' => 'Suave CRM',
                'subtitle' => '',
                'items' => [
                    ['icon' => 'fa-check', 'title' => 'Free for small and mid-size companies', 'description' => 'No per-seat bill that grows with every hire.'],
                    ['icon' => 'fa-layer-group', 'title' => 'One login for the whole company', 'description' => 'Sales, delivery, HR and billing share the same data.'],
                    ['icon' => 'fa-robot', 'title' => 'AI included, not upsold', 'description' => 'Lead scoring, briefings, follow-ups and task help come with the free CRM.'],
                    ['icon' => 'fa-globe', 'title' => 'Works anywhere', 'description' => 'A web app available worldwide, in any modern browser.'],
                    ['icon' => 'fa-shield-halved', 'title' => 'Your data stays yours', 'description' => 'We never sell it, and Gmail access is optional and revocable.'],
                    ['icon' => 'fa-code', 'title' => 'Built by engineers', 'description' => 'Suave CRM is made by Suave Creators, who also build custom CRMs for companies that need a fully owned system.'],
                ],
                'visual' => self::modulePanelVisual(
                    'Why Suave',
                    'What you keep',
                    [
                        ['label' => 'Price', 'value' => 'Free'],
                        ['label' => 'AI', 'value' => 'Included'],
                        ['label' => 'Tools replaced', 'value' => '5'],
                    ],
                    ['No per-seat bill', 'One shared login', 'AI included', 'Data stays yours'],
                ),
            ],
        ];
    }

    /**
     * @return array{
     *     type: string,
     *     eyebrow: string,
     *     title: string,
     *     action: string,
     *     metrics: array<int, array{label: string, value: string, icon: string}>,
     *     stages: array<int, array{label: string, count: int, leads: array<int, array{initials: string, company: string, project: string, amount: string, fit: string}>}>
     * }
     */
    protected static function salesPipelineVisual(): array
    {
        return [
            'type' => 'pipeline',
            'eyebrow' => 'Sales Pipeline',
            'title' => 'Opportunities',
            'action' => '+ Add Lead',
            'metrics' => [
                ['label' => 'Pipeline value', 'value' => '$384,200', 'icon' => 'fa-chart-simple'],
                ['label' => 'Conversion', 'value' => '28.4%', 'icon' => 'fa-chart-simple'],
                ['label' => 'AI Qualified', 'value' => '64 leads', 'icon' => 'fa-robot'],
            ],
            'stages' => [
                [
                    'label' => 'New Leads',
                    'count' => 12,
                    'leads' => [
                        ['initials' => 'FL', 'company' => 'Frame Labs', 'project' => 'Website redesign', 'amount' => '$24,500', 'fit' => '94'],
                        ['initials' => 'NC', 'company' => 'Northstar Co.', 'project' => 'Website redesign', 'amount' => '$18,200', 'fit' => '91'],
                    ],
                ],
                [
                    'label' => 'Qualified',
                    'count' => 8,
                    'leads' => [
                        ['initials' => 'LS', 'company' => 'Lumen Studio', 'project' => 'Website redesign', 'amount' => '$32,000', 'fit' => '96'],
                        ['initials' => 'AP', 'company' => 'Apex Partners', 'project' => 'Website redesign', 'amount' => '$21,750', 'fit' => '89'],
                    ],
                ],
                [
                    'label' => 'Proposal',
                    'count' => 5,
                    'leads' => [
                        ['initials' => 'HV', 'company' => 'Harbor Ventures', 'project' => 'Website redesign', 'amount' => '$41,000', 'fit' => '97'],
                        ['initials' => 'BK', 'company' => 'Brightline Kit', 'project' => 'Website redesign', 'amount' => '$15,400', 'fit' => '88'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param  array<int, array{label: string, value: string}>  $metrics
     * @param  array<int, string>  $rows
     * @return array{type: string, eyebrow: string, title: string, metrics: array<int, array{label: string, value: string}>, rows: array<int, string>}
     */
    protected static function modulePanelVisual(string $eyebrow, string $title, array $metrics, array $rows): array
    {
        return [
            'type' => 'panel',
            'eyebrow' => $eyebrow,
            'title' => $title,
            'metrics' => $metrics,
            'rows' => $rows,
        ];
    }

    /**
     * @return array{
     *     type: string,
     *     label: string,
     *     prompt: string,
     *     briefLabel: string,
     *     briefTitle: string,
     *     priorities: array<int, string>,
     *     inputPlaceholder: string
     * }
     */
    protected static function askSuaveVisual(): array
    {
        return [
            'type' => 'ask-suave',
            'label' => 'Ask Suave',
            'prompt' => 'What needs my attention today?',
            'briefLabel' => "Here's your daily brief",
            'briefTitle' => '3 priorities for this morning',
            'priorities' => [
                'Call Nova systems - high-intent lead',
                'Atlas proposal is due today',
                '2 project tasks need reassignment',
            ],
            'inputPlaceholder' => 'Ask about leads, tasks, or projects...',
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
            'badge' => 'Privacy',
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
            'image' => asset('assets/product/product-og-banner.webp'),
            'screenshot' => asset('assets/product/hero_banner.webp'),
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
