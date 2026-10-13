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
        $faqs = self::faqs();

        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900 product-site product-layout',
            'mainClass' => 'site-main product-layout-main',
            'useHeroBackground' => true,
            'heroBackgroundImage' => '',
            'contactHref' => ContactSupport::demoHref(),
            'demoHref' => ContactSupport::demoHref(),
            'signupUrl' => self::SIGNUP_URL,
            'heroBackground' => asset('assets/product/product-top-sections-bg.webp'),
            'heroEyebrow' => 'Free CRM · Sales + Projects + HR + Invoicing',
            'heroTitle' => 'Free CRM for Agencies and Startups: Sales, Projects, HR and Invoicing in One App',
            'heroSubtitle' => 'Stop paying for five tools. Suave CRM gives small and mid-size teams a free sales pipeline, project management, timesheets, attendance, HR and invoicing, with an AI assistant built in. Sign up and start today, from anywhere in the world.',
            'heroTrustLine' => 'Free for small and mid-size companies · No payment needed · Works in any browser, worldwide',
            'heroDemoLinkLabel' => 'Prefer a walkthrough first? Book a demo →',
            'heroProof' => self::heroProof(),
            'heroBanner' => [
                'src' => asset('assets/product/hero_banner.webp'),
                'backSrc' => asset('assets/product/hero_banner_back.webp'),
                'alt' => 'Suave CRM demo dashboard with sales pipeline, today tasks, punch-in timer and attendance calendar',
                'backAlt' => 'Soft blue screen blend glow layer behind Suave CRM free all-in-one CRM hero banner',
            ],
            'glance' => self::glance(),
            'savings' => self::savings(),
            'sales' => self::sales(),
            'projects' => self::projects(),
            'timeBilling' => self::timeBilling(),
            'teamHr' => self::teamHr(),
            'askSuave' => self::askSuave(),
            'audiences' => self::audiences(),
            'gettingStarted' => self::gettingStarted(),
            'whySwitch' => self::whySwitch(),
            'dataPrivacy' => self::dataPrivacy(),
            'testimonial' => self::testimonial(),
            'faqs' => $faqs,
            'finalCta' => self::finalCta(),
            'stickyBar' => [
                'label' => 'Free CRM for your team',
                'button' => 'Sign Up Free',
            ],
            'seoFaqs' => $faqs,
            'seoBreadcrumbName' => 'Suave CRM',
            'seoTwitterTitle' => 'Free All-in-One CRM for Agencies & Startups | Suave CRM',
            'seoTwitterDescription' => 'Sales, projects, timesheets, HR and invoicing in one free app. Sign up free, no payment needed.',
            'seoOgImageAlt' => 'Suave CRM free CRM dashboard with sales pipeline, project tasks and attendance calendar',
        ];
    }

    /**
     * @return array{quote: string, name: string, role: string, company: string}
     */
    protected static function heroProof(): array
    {
        return [
            'quote' => 'Our team responds faster, works smarter, and closes more deals.',
            'name' => 'Amit Rana',
            'role' => 'Managing Director',
            'company' => 'Turbo Trans Corporation',
        ];
    }

    /**
     * @return array{title: string, rows: list<array{label: string, value: string}>}
     */
    protected static function glance(): array
    {
        return [
            'title' => 'Suave CRM at a glance',
            'rows' => [
                ['label' => 'Price', 'value' => 'Free for small and mid-size companies'],
                ['label' => "What's included", 'value' => 'Sales pipeline, AI lead scoring, projects and tasks, timesheets, attendance and HR, invoicing, team messaging, documents and an AI assistant'],
                ['label' => 'Best for', 'value' => 'IT agencies, software development companies, web and digital agencies, startups and growing teams'],
                ['label' => 'Platform', 'value' => 'Web app; works in any modern browser'],
                ['label' => 'Availability', 'value' => 'Worldwide'],
                ['label' => 'Email', 'value' => 'Send from your own Gmail account (optional connection)'],
                ['label' => 'Getting started', 'value' => 'Sign up with your work email and start; demo available on request'],
                ['label' => 'Made by', 'value' => 'Suave Creators, a US-registered software company with an engineering center in India'],
            ],
        ];
    }

    /**
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     body: string,
     *     headers: list<string>,
     *     rows: list<array{job: string, usual: string, withSuave: string}>,
     *     button: string,
     *     microcopy: string
     * }
     */
    protected static function savings(): array
    {
        return [
            'eyebrow' => 'What you save',
            'title' => 'One free CRM instead of five subscriptions',
            'body' => "Most growing teams pay separately for a CRM, a project tool, time tracking, an HR or attendance app and invoicing software, and many of those charge per user. When teams outgrow free plans, the bill climbs fast: HubSpot's Sales Hub Professional, for example, lists at USD 90 per seat per month billed annually, so 15 seats is USD 1,350 a month for the CRM alone. Suave CRM puts all five jobs in one app, free for small and mid-size companies.",
            'headers' => ['Job', 'What teams usually pay for', 'With Suave CRM'],
            'rows' => [
                ['job' => 'Sales pipeline', 'usual' => 'A per-seat CRM', 'withSuave' => 'Included free'],
                ['job' => 'Projects and tasks', 'usual' => 'A project management subscription', 'withSuave' => 'Included free'],
                ['job' => 'Time tracking', 'usual' => 'A time-tracking app', 'withSuave' => 'Included free'],
                ['job' => 'Attendance and HR', 'usual' => 'An HR or attendance tool', 'withSuave' => 'Included free'],
                ['job' => 'Invoicing', 'usual' => 'An invoicing tool', 'withSuave' => 'Included free'],
            ],
            'button' => 'Sign Up Free',
            'microcopy' => 'Set up your workspace in minutes.',
        ];
    }

    /**
     * @return array{id: string, title: string, intro: string, items: list<array{title: string, body: string}>, linkLabel: string}
     */
    protected static function sales(): array
    {
        return [
            'id' => 'sales',
            'eyebrow' => 'Sales',
            'title' => 'Free sales CRM with AI lead scoring',
            'intro' => 'Win more clients without a sales-ops team. Every lead lands in one place, AI tells you which ones to call first, and your pipeline updates itself as deals move.',
            'items' => [
                [
                    'title' => 'AI lead qualification',
                    'body' => 'Leads from forms, ads, your website, calls and email are scored automatically.',
                ],
                [
                    'title' => 'Visual pipeline',
                    'body' => 'Every deal, conversation and next step on one board.',
                ],
                [
                    'title' => 'Company discovery',
                    'body' => 'Find companies that fit your ideal client profile by map or list.',
                ],
                [
                    'title' => 'Suave AI briefings',
                    'body' => 'A short brief on each prospect before you reach out.',
                ],
                [
                    'title' => 'Email from your own Gmail',
                    'body' => 'Write, send and follow up from your real address with S-Mail, with AI drafts and open tracking.',
                ],
            ],
            'linkLabel' => 'Start with the free sales CRM → Sign Up Free',
        ];
    }

    /**
     * @return array{id: string, eyebrow: string, title: string, intro: string, items: list<array{title: string, body: string}>}
     */
    protected static function projects(): array
    {
        return [
            'id' => 'projects',
            'eyebrow' => 'Projects',
            'title' => 'Free project management for client work',
            'intro' => 'When a deal closes, the work starts in the same app. No hand-off, no copy-paste into another tool.',
            'items' => [
                [
                    'title' => 'Projects & Tasks',
                    'body' => 'Kanban and list views, owners, due dates and an AI assistant for overdue and assigned work.',
                ],
                [
                    'title' => 'My tasks every morning',
                    'body' => "Each person sees what's due today, filtered by status, the moment they log in.",
                ],
                [
                    'title' => 'Documents',
                    'body' => 'Proposals, contracts and files stay on the client record.',
                ],
                [
                    'title' => 'Messenger',
                    'body' => 'Discuss a deal or project in context, not in a separate chat app.',
                ],
            ],
        ];
    }

    /**
     * @return array{id: string, eyebrow: string, title: string, intro: string, items: list<array{title: string, body: string}>}
     */
    protected static function timeBilling(): array
    {
        return [
            'id' => 'time-billing',
            'eyebrow' => 'Time and billing',
            'title' => 'Free timesheet and invoicing software',
            'intro' => 'Track every billable hour and turn it into an invoice without exporting a spreadsheet.',
            'items' => [
                [
                    'title' => 'Timesheets',
                    'body' => 'Log hours against projects and clients.',
                ],
                [
                    'title' => 'Invoicing',
                    'body' => 'Create and send invoices from won deals and logged time.',
                ],
                [
                    'title' => 'Targets and analytics',
                    'body' => 'Sales goals, team progress and project dashboards, live.',
                ],
            ],
        ];
    }

    /**
     * @return array{id: string, eyebrow: string, title: string, intro: string, items: list<array{title: string, body: string}>}
     */
    protected static function teamHr(): array
    {
        return [
            'id' => 'team-hr',
            'eyebrow' => 'Team and HR',
            'title' => 'Free attendance and HR software, built in',
            'intro' => "Know who's working, how the month is going and where time goes, without a separate HR system.",
            'items' => [
                [
                    'title' => 'Punch in and out',
                    'body' => 'From the dashboard, with a live timer and each person\'s shift timing.',
                ],
                [
                    'title' => 'Attendance calendar',
                    'body' => 'Showing present days, leave and holidays.',
                ],
                [
                    'title' => 'Monthly insights',
                    'body' => 'Working vs. worked hours, attendance percentage and efficiency per person.',
                ],
                [
                    'title' => 'HR profiles',
                    'body' => 'Department, designation, shift and joining date for the whole team.',
                ],
            ],
        ];
    }

    /**
     * @return array{id: string, eyebrow: string, title: string, items: list<string>, button: string}
     */
    protected static function askSuave(): array
    {
        return [
            'id' => 'ask-suave',
            'eyebrow' => 'AI',
            'title' => 'Ask Suave: the AI assistant that runs through your CRM',
            'items' => [
                'Ask Suave from any screen for answers about your leads, projects and tasks.',
                'A daily brief on every dashboard, so each person knows where to start.',
                'AI everywhere it saves time: lead scoring, prospect briefings, follow-up drafts and task help, at no extra cost.',
            ],
            'button' => 'Sign Up Free',
        ];
    }

    /**
     * @return array{title: string, items: list<array{title: string, body: string}>}
     */
    protected static function audiences(): array
    {
        return [
            'title' => 'The free CRM built for how agencies and startups actually work',
            'items' => [
                [
                    'title' => 'IT services and software development companies',
                    'body' => 'Track deals, run client projects, log billable hours and invoice, all against the same client record.',
                ],
                [
                    'title' => 'Web, design and digital agencies',
                    'body' => "Juggle many clients at once: see every project's tasks, hours and invoices without switching tools.",
                ],
                [
                    'title' => 'Startups',
                    'body' => 'Get a CRM, project tracker and HR basics on day one, for free, and keep them as the team grows.',
                ],
                [
                    'title' => 'Growing small and mid-size teams',
                    'body' => 'Replace spreadsheets and scattered apps with one system everyone actually logs into.',
                ],
            ],
        ];
    }

    /**
     * @return array{title: string, steps: list<string>, help: string, button: string}
     */
    protected static function gettingStarted(): array
    {
        return [
            'title' => 'How to start using Suave CRM for free',
            'steps' => [
                'Sign up with your work email. No payment needed.',
                'Invite your team and switch on the modules you need: sales, projects, timesheets, HR or invoicing.',
                'Add your first leads and projects, and let Ask Suave guide the rest.',
            ],
            'help' => "Want help setting up? Book a demo and we'll walk your team through it.",
            'button' => 'Sign Up Free',
        ];
    }

    /**
     * @return array{title: string, items: list<array{title: string, body: string}>}
     */
    protected static function whySwitch(): array
    {
        return [
            'title' => 'Why growing teams choose Suave CRM',
            'items' => [
                [
                    'title' => 'Free for small and mid-size companies',
                    'body' => 'No per-seat bill that grows with every hire.',
                ],
                [
                    'title' => 'One login for the whole company',
                    'body' => 'Sales, delivery, HR and billing share the same data.',
                ],
                [
                    'title' => 'AI included, not upsold',
                    'body' => 'Lead scoring, briefings, follow-ups and task help come with the free CRM.',
                ],
                [
                    'title' => 'Works anywhere',
                    'body' => 'A web app available worldwide, in any modern browser.',
                ],
                [
                    'title' => 'Your data stays yours',
                    'body' => 'We never sell it, and Gmail access is optional and revocable.',
                ],
                [
                    'title' => 'Built by engineers',
                    'body' => 'Suave CRM is made by Suave Creators, who also build custom CRMs for companies that need a fully owned system.',
                ],
            ],
        ];
    }

    /**
     * @return array{
     *     badge: string,
     *     title: string,
     *     description: string,
     *     links: list<array{label: string, href: string, external: bool}>,
     *     background: string,
     *     graphic: array{src: string, alt: string}
     * }
     */
    protected static function dataPrivacy(): array
    {
        return [
            'badge' => 'Privacy',
            'title' => 'Is my data safe in Suave CRM?',
            'description' => "Connecting Gmail is optional. You sign in with Google OAuth, Google's consent screen shows exactly what S-Mail requests, and you can disconnect anytime in Suave CRM or revoke access in your Google Account. We access only the Gmail data you authorize, and we do not sell Google user data, use it for ads, or train generalized AI or ML models on it.",
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
     * @return array{
     *     quote: string,
     *     name: string,
     *     role: string,
     *     company: string,
     *     resultsLabel: string,
     *     resultsHref: string,
     *     quoteMark: array{src: string, alt: string},
     *     avatar: array{src: string, alt: string}
     * }
     */
    protected static function testimonial(): array
    {
        return [
            'quote' => 'The Suave Sales CRM streamlined our entire sales process. Our team responds faster, works smarter, and closes more deals.',
            'name' => 'Amit Rana',
            'role' => 'Managing Director',
            'company' => 'Turbo Trans Corporation',
            'resultsLabel' => 'See more client results →',
            'resultsHref' => route('case-studies'),
            'quoteMark' => [
                'src' => asset('assets/product/case-study-quote-mark-blue.png'),
                'alt' => 'Blue opening quotation mark icon for Suave CRM client testimonial',
            ],
            'avatar' => [
                'src' => asset('assets/product/generic-user-profile-avatar.png'),
                'alt' => 'Amit Rana Managing Director Turbo Trans Corporation Suave CRM testimonial portrait',
            ],
        ];
    }

    /**
     * @return list<array{question: string, answer: string}>
     */
    protected static function faqs(): array
    {
        return [
            [
<<<<<<< HEAD
                'question' => 'Is Suave CRM really free?',
                'answer' => 'Yes. Suave CRM is free for small and mid-size companies. Sign up with your work email and start using it; no payment is needed.',
=======
                'value' => '42%',
                'label' => 'More Qualified Leads',
                'caption' => 'Vs. Previous Quarter',
                'tone' => 'blue',
                'icon' => asset('assets/product/leads.png'),
                'alt' => 'Qualified leads growth icon for Suave AI sales CRM case study metric',
                'chart' => asset('assets/product/graph_vector1.png'),
                'chartVariant' => 'strip',
>>>>>>> 0d60060cbf6ddc4d43a6f348c1bdaaebf125b478
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
     * @return array{title: string, body: string, trustLine: string, demoLinkLabel: string}
     */
    protected static function finalCta(): array
    {
        return [
            'title' => 'Run your whole company from one free CRM',
            'body' => 'Sales, projects, timesheets, HR and invoicing, with AI built in. Free for small and mid-size companies, anywhere in the world.',
            'trustLine' => 'No payment needed · Available worldwide',
            'demoLinkLabel' => 'Prefer a walkthrough? Book a demo →',
        ];
    }

    /**
     * SEO structured-data overrides for the product page (JSON-LD graph nodes).
     *
     * @return array{seoJsonLdGraph: array<int, array<string, mixed>>, seoJsonLdWebpageAbout: string}
     */
    public static function seoStructuredData(): array
    {
        $pageUrl = rtrim(route('product'), '/');
        $softwareId = $pageUrl.'#software';

        return [
            'seoJsonLdGraph' => [self::jsonLdSoftwareApplication($pageUrl, $softwareId)],
            'seoJsonLdWebpageAbout' => $softwareId,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function jsonLdSoftwareApplication(string $pageUrl, string $softwareId): array
    {
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');
        $name = (string) (config('seo.pages.product.json_ld_name') ?? 'Suave CRM');
        $description = (string) (config('seo.pages.product.json_ld_description')
            ?? config('seo.pages.product.description')
            ?? 'Suave CRM');
        $image = asset('assets/product/product-og-banner.webp');
        $screenshot = asset('assets/product/hero_banner.webp');

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
            'image' => $image,
            'screenshot' => $screenshot,
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
            'featureList' => [
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
            ],
            'offers' => [
                '@type' => 'Offer',
                'name' => 'Free for small and mid-size companies',
                'price' => '0',
                'priceCurrency' => 'USD',
                'areaServed' => 'Worldwide',
                'url' => $pageUrl,
            ],
        ], static fn (mixed $value): bool => $value !== null && $value !== '');
    }
}
