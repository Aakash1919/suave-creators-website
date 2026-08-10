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
            'contactHref' => route('contact-us').'#contact-id',
            'heroBadge' => '✨ AI - POWERED SALES CRM',
            'heroBackground' => asset('assets/product/product-top-sections-bg.png'),
            'heroFloatingStats' => self::heroFloatingStats(),
            'heroChips' => self::heroChips(),
            'heroBanner' => [
                'src' => asset('assets/product/product-hero-banner.png'),
                'alt' => 'Suave AI sales CRM dashboard with lead capture, AI follow-up, deal won and company discovery analytics',
            ],
            'howItWorksSteps' => self::howItWorksSteps(),
            'addOns' => self::addOns(),
            'businessWorks' => self::businessWorks(),
            'dataPrivacy' => self::dataPrivacy(),
            'caseStudy' => self::caseStudy(),
            'salesCta' => self::salesCta(),
            'pricing' => self::pricing(),
        ];
    }

    /**
     * @return array<int, array{position: string, src: string, alt: string}>
     */
    protected static function heroFloatingStats(): array
    {
        return [
            [
                'position' => 'left',
                'src' => asset('assets/product/tile1.png'),
                'alt' => 'Suave AI sales CRM website briefing analysis stat card',
            ],
            [
                'position' => 'right',
                'src' => asset('assets/product/Tile-2.png'),
                'alt' => 'Suave CRM S-Mail cold email outreach performance stat card',
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
                'icon' => asset('assets/product/hero-chip-ai-assistant.svg'),
                'label' => 'AI Assistant',
                'alt' => 'AI assistant icon for the Suave AI powered sales CRM',
            ],
            [
                'icon' => asset('assets/product/hero-chip-smart-automation.svg'),
                'label' => 'Smart Automation',
                'alt' => 'Smart automation icon for AI driven sales workflow software',
            ],
            [
                'icon' => asset('assets/product/hero-chip-real-time-analysis.svg'),
                'label' => 'Real-time Analysis',
                'alt' => 'Real-time sales analytics icon for AI CRM revenue reporting',
            ],
            [
                'icon' => asset('assets/product/hero-chip-secure-reliable.svg'),
                'label' => 'Secure & Reliable',
                'alt' => 'Security and reliability icon for enterprise sales CRM software',
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
                'icon' => asset('assets/product/how-it-works-capture-lead-icon.svg'),
                'title' => 'Capture Lead',
                'description' => 'Bring every lead into one centralized workspace, whether it comes from forms, ads, websites, calls, or emails',
                'alt' => 'Capture lead icon for Suave AI sales CRM lead intake',
            ],
            [
                'icon' => asset('assets/product/how-it-works-ai-qualification-icon.svg'),
                'title' => 'AI Qualification',
                'description' => 'AI scores and qualifies leads, ensuring your team spends time on the right opportunities instead of chasing every lead.',
                'alt' => 'AI qualification icon for Suave sales CRM lead scoring',
            ],
            [
                'icon' => asset('assets/product/how-it-works-manage-pipeline-icon.svg'),
                'title' => 'Manage Pipeline',
                'description' => 'Track every conversation, activity, and deal stage in a visual sales pipeline to improve collaboration and productivity.',
                'alt' => 'Manage pipeline icon for Suave AI powered sales CRM',
            ],
            [
                'icon' => asset('assets/product/how-it-works-close-deals-icon.svg'),
                'title' => 'Close Deals',
                'description' => 'Automate follow-ups, gain AI-powered insights, and close more deals faster with intelligent sales automation.',
                'alt' => 'Close deals icon for Suave AI sales CRM automation',
            ],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, description: string, alt: string}>
     */
    protected static function addOns(): array
    {
        $description = 'Plan delivery work beside the deals you just opened.';

        return [
            [
                'icon' => asset('assets/product/addon-projects-tasks-icon.svg'),
                'title' => 'Projects & Tasks',
                'description' => $description,
                'alt' => 'Projects and tasks add-on icon for Suave CRM work management',
            ],
            [
                'icon' => asset('assets/product/addon-attendance-icon.svg'),
                'title' => 'Attendance',
                'description' => $description,
                'alt' => 'Attendance tracking add-on icon for Suave CRM team management',
            ],
            [
                'icon' => asset('assets/product/addon-timesheets-icon.svg'),
                'title' => 'Timesheets',
                'description' => $description,
                'alt' => 'Timesheets add-on icon for Suave CRM delivery time tracking',
            ],
            [
                'icon' => asset('assets/product/addon-invoicing-icon.svg'),
                'title' => 'Invoicing',
                'description' => $description,
                'alt' => 'Invoicing add-on icon for Suave CRM billing and finance',
            ],
            [
                'icon' => asset('assets/product/addon-documents-icon.svg'),
                'title' => 'Documents',
                'description' => $description,
                'alt' => 'Documents add-on icon for Suave CRM file and knowledge management',
            ],
            [
                'icon' => asset('assets/product/addon-messenger-icon.svg'),
                'title' => 'Messenger',
                'description' => $description,
                'alt' => 'Messenger add-on icon for Suave CRM team communication',
            ],
            [
                'icon' => asset('assets/product/addon-targets-icon.svg'),
                'title' => 'Targets',
                'description' => $description,
                'alt' => 'Targets add-on icon for Suave CRM goal and KPI tracking',
            ],
            [
                'icon' => asset('assets/product/addon-email-management-icon.svg'),
                'title' => 'Email Management',
                'description' => $description,
                'alt' => 'Email management add-on icon for Suave CRM inbox workflows',
            ],
        ];
    }

    /**
     * @return array{
     *     badge: string,
     *     title: string,
     *     titleAccent: string,
     *     subtitle: string,
     *     cards: array<int, array<string, mixed>>
     * }
     */
    protected static function businessWorks(): array
    {
        return [
            'badge' => 'The-Suave AI',
            'title' => 'How The-Suave works',
            'titleAccent' => 'for Your Business',
            'subtitle' => 'The-Suave is your all-in-one AI business operating system. It connects your teams, projects, CRM, communication, and workflows into one intelligent workspace, helping you automate repetitive work, collaborate faster, and make smarter decisions with AI.',
            'cards' => self::businessWorksCards(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected static function businessWorksCards(): array
    {
        return [
            [
                'icon' => asset('assets/product/business-works-gmail-link-icon.svg'),
                'title' => 'Link Gmail with Google',
                'description' => 'You sign in with Google OAuth and grant S-Mail permission to access your Gmail account. Connection is optional, user-initiated, and can be disconnected anytime in the product or revoked in your Google Account.',
                'alt' => 'Link Gmail with Google icon for Suave AI S-Mail OAuth integration',
                'footerType' => 'integrations',
                'integrations' => [
                    [
                        'src' => asset('assets/product/integration-google-logo.svg'),
                        'alt' => 'Google logo for Suave AI Gmail OAuth integration',
                    ],
                    [
                        'src' => asset('assets/product/integration-google-calendar-logo.svg'),
                        'alt' => 'Google Calendar logo for Suave AI workspace integration',
                    ],
                    [
                        'src' => asset('assets/product/integration-slack-logo.svg'),
                        'alt' => 'Slack logo for Suave AI team communication integration',
                    ],
                    [
                        'src' => asset('assets/product/integration-gmail-logo.svg'),
                        'alt' => 'Gmail logo for Suave AI S-Mail cold outreach integration',
                    ],
                    [
                        'src' => asset('assets/product/integration-plus-icon.svg'),
                        'alt' => 'More integrations available in Suave AI business operating system',
                    ],
                ],
            ],
            [
                'icon' => asset('assets/product/business-works-ai-mailbox-icon.svg'),
                'title' => 'AI in your mailbox',
                'description' => 'Reply, rephrase, and smart-compose inside S-Mail, and draft Outreach cold email from company briefings, then send through your connected Gmail so mail leaves from your real address.',
                'alt' => 'AI mailbox icon for Suave AI S-Mail smart compose and outreach',
                'footerType' => 'tags',
                'tags' => ['Smart AI', 'Context Aware', 'Always Learning'],
            ],
            [
                'icon' => asset('assets/product/business-works-track-sends-icon.svg'),
                'title' => 'Track sends you make',
                'description' => 'Outbound mail sent through S-Mail / Outreach can include delivery and open tracking so your team sees what landed, used only for the email features you enable.',
                'alt' => 'Track email sends icon for Suave AI S-Mail delivery and open tracking',
                'footerType' => 'tags',
                'tags' => ['Automation', 'Insights', 'Growth'],
            ],
        ];
    }

    /**
     * @return array{
     *     badge: string,
     *     titleLine1: string,
     *     titleLine2: string,
     *     description: string,
     *     bullets: array<int, string>,
     *     links: array<int, array{label: string, href: string, external: bool}>,
     *     background: string,
     *     graphic: array{src: string, alt: string}
     * }
     */
    protected static function dataPrivacy(): array
    {
        return [
            'badge' => 'Data & Privacy',
            'titleLine1' => 'Your data is yours.',
            'titleLine2' => 'We just keep it safe.',
            'description' => 'Connecting Gmail is optional. Google shows the OAuth consent screen with the scopes we request, we ask only for what S-Mail and Outreach send need. Declining consent leaves other Suave CRM features available.',
            'background' => asset('assets/product/data-privacy-section-bg.webp'),
            'bullets' => [
                'Access Gmail data you authorize (messages, threads, labels, drafts, send) to sync and operate S-Mail.',
                'Send and save Outreach cold email through your connected Gmail account.',
                'Show conversation context for leads you contact from Outreach.',
                'We do not sell Google user data, use it for ads, or train generalized AI / ML models on it.',
            ],
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
                    'label' => 'Google Limited Use',
                    'href' => 'https://developers.google.com/terms/api-services-user-data-policy',
                    'external' => true,
                ],
            ],
            'graphic' => [
                'src' => asset('assets/product/data-privacy-security-infographic.webp'),
                'alt' => 'Suave AI data privacy security infographic showing CRM modules protected by a central shield',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function caseStudy(): array
    {
        return [
            'badge' => 'Case Study',
            'titlePrefix' => 'Success Story:',
            'titleAccent' => 'Turbo Trans Corporation',
            'subtitle' => 'See how a logistics leader transformed their sales operations with AI-powered CRM automation',
            'logo' => [
                'src' => asset('assets/product/turbo-trans-corporation-logo.svg'),
                'alt' => 'Turbo Trans Corporation logistics company logo for Suave AI CRM case study',
            ],
            'tags' => [
                ['icon' => 'fa-truck', 'label' => 'Logistics & Freight'],
                ['icon' => 'fa-globe', 'label' => 'Global Operations'],
                ['icon' => 'fa-users', 'label' => '100+ Employees'],
            ],
            'intro' => 'Turbo Trans Corporation is a leading logistics and freight company with global operations spanning multiple continents and over 100 employees.',
            'challenge' => [
                'title' => 'The Challenge',
                'items' => [
                    'Leads coming from multiple sources with no unified tracking',
                    'Delayed follow-ups causing lost opportunities',
                    'Manual lead qualification consuming valuable sales time',
                    'No visibility into pipeline health and conversion rates',
                ],
            ],
            'solution' => [
                'title' => 'The Solution',
                'intro' => 'The Suave Sales CRM transformed their sales operations with:',
                'items' => [
                    'AI-powered lead qualification and scoring',
                    'Automated follow-up reminders and sequences',
                    'Unified pipeline management across all channels',
                    'Real-time analytics and performance insights',
                ],
            ],
            'metrics' => self::caseStudyMetrics(),
            'testimonial' => [
                'quote' => 'Suave CRM completely transformed how we manage leads and close deals. Our team now responds faster, qualifies better, and has complete visibility into every opportunity.',
                'name' => 'Rajesh Patel',
                'role' => 'Sales Director',
                'company' => 'Turbo Trans Corporation',
                'avatar' => [
                    'src' => asset('assets/product/rajesh-patel-sales-director-portrait.svg'),
                    'alt' => 'Rajesh Patel Sales Director Turbo Trans Corporation Suave AI CRM testimonial portrait',
                ],
            ],
            'cta' => [
                'title' => 'Want Similar Results?',
                'description' => 'Book a demo to see how Suave CRM can transform your sales operations.',
                'button' => 'Book a Free Demo',
            ],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    protected static function caseStudyMetrics(): array
    {
        return [
            [
                'value' => '42%',
                'label' => 'More Qualified Leads',
                'caption' => 'vs. Previous Quarter',
                'tone' => 'blue',
                'icon' => asset('assets/product/case-study-metric-qualified-leads-icon.svg'),
                'alt' => 'Qualified leads growth icon for Suave AI sales CRM case study metric',
            ],
            [
                'value' => '3.4x',
                'label' => 'Faster Response Time',
                'caption' => 'Average Lead Response',
                'tone' => 'purple',
                'icon' => asset('assets/product/case-study-metric-response-time-icon.svg'),
                'alt' => 'Faster response time icon for Suave AI CRM automation case study',
            ],
            [
                'value' => '68%',
                'label' => 'Pipeline Visibility',
                'caption' => 'Complete Deal Tracking',
                'tone' => 'teal',
                'icon' => asset('assets/product/case-study-metric-pipeline-visibility-icon.svg'),
                'alt' => 'Pipeline visibility icon for Suave AI sales CRM deal tracking case study',
            ],
            [
                'value' => '2.8x',
                'label' => 'Revenue Growth',
                'caption' => 'Year-over-Year Increase',
                'tone' => 'orange',
                'icon' => asset('assets/product/case-study-metric-revenue-growth-icon.svg'),
                'alt' => 'Revenue growth icon for Suave AI powered sales CRM success story',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function salesCta(): array
    {
        return [
            'badge' => 'Want Similar Results?',
            'titlePrefix' => 'Ready to Build a',
            'titleAccent' => 'Smarter Sales Team?',
            'description' => 'See how The Suave Sales CRM can help your business capture more leads, automate sales workflows, and close deals faster.',
            'button' => 'Book Free Demo',
            'dealCard' => [
                'title' => 'New Deal',
                'company' => 'Acme Corporation',
                'amount' => '$74.25',
                'category' => 'Digital Marketing',
                'avatar' => [
                    'src' => asset('assets/product/product-sales-cta-deal-avatar.svg'),
                    'alt' => 'New deal contact avatar for Suave AI sales CRM demo preview card',
                ],
            ],
            'insightCard' => [
                'title' => 'AI Insight',
                'description' => 'This lead is highly likely to convert based on its behavior and engagement.',
                'icon' => [
                    'src' => asset('assets/product/product-sales-cta-ai-insight-icon.svg'),
                    'alt' => 'AI insight icon for Suave AI sales CRM lead conversion preview card',
                ],
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
                'icon' => asset('assets/product/pricing-plan-free-icon.svg'),
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
                'icon' => asset('assets/product/pricing-plan-starter-icon.svg'),
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
                'icon' => asset('assets/product/pricing-plan-growth-icon.svg'),
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
                'icon' => asset('assets/product/pricing-plan-enterprise-icon.svg'),
                'alt' => 'Enterprise plan icon for Suave AI CRM custom organization pricing',
            ],
        ];
    }
}
