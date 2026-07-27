<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class ProductSupport
{
    use MapsDesignAssets;

    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        $modules = self::modules();
        $firstModule = $modules[0] ?? [];

        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900 product-site product-layout',
            'mainClass' => 'site-main product-layout-main',
            'contactHref' => route('contact-us').'#contact-id',
            'stats' => self::stats(),
            'features' => self::features(),
            'workspaceBullets' => [
                'Real-time sync across all modules.',
                'One login for your entire team.',
                'Unified notifications & activity feed.',
                'Custom roles & permission levels.',
            ],
            'modules' => $modules,
            'firstModule' => $firstModule,
            'pricingPlans' => self::pricingPlans(),
            'productivityFeatures' => self::productivityFeatures(),
            'principles' => self::principles(),
            'partnerCards' => self::partnerCards(),
            'socialLinks' => self::socialLinks(),
        ];
    }

    /**
     * @return array<int, array{icon: string, value: string, label: string, alt: string}>
     */
    protected static function stats(): array
    {
        return [
            ['icon' => asset('assets/product/stat-icon-modules.svg'), 'value' => '12+', 'label' => 'INTEGRATED MODULES', 'alt' => 'Integrated modules icon for Suave CRM product platform'],
            ['icon' => asset('assets/product/stat-icon-workspace.svg'), 'value' => '01', 'label' => 'UNIFIED WORKSPACE', 'alt' => 'Unified workspace icon for Suave CRM software'],
            ['icon' => asset('assets/product/stat-icon-shield.svg'), 'value' => '100%', 'label' => 'TENANT DATA ISOLATION', 'alt' => 'Tenant data isolation security icon for Suave CRM'],
            ['icon' => asset('assets/product/stat-icon-clock.svg'), 'value' => '24/7', 'label' => 'ALWAYS AVAILABLE', 'alt' => 'Always available uptime icon for Suave CRM platform'],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, description: string, alt: string}>
     */
    protected static function features(): array
    {
        return [
            [
                'icon' => asset('assets/product/feature-icon-lightning.svg'),
                'title' => 'Lightning Fast',
                'description' => 'Sub-100ms responses across all modules. Your team never waits.',
                'alt' => 'Lightning fast performance icon for Suave CRM software development',
            ],
            [
                'icon' => asset('assets/product/feature-icon-shield.svg'),
                'title' => 'Enterprise Security',
                'description' => 'Role-based access, audit logs, and SOC2-ready infrastructure.',
                'alt' => 'Enterprise security icon for Suave CRM custom software platform',
            ],
            [
                'icon' => asset('assets/product/feature-icon-ai.svg'),
                'title' => 'AI-Powered',
                'description' => 'Built-in AI assistant for report generation, summarization, and smart suggestions.',
                'alt' => 'AI powered assistant icon for Suave CRM enterprise software',
            ],
            [
                'icon' => asset('assets/product/feature-icon-team.svg'),
                'title' => 'Team-First Design',
                'description' => 'Designed for how creative teams actually work — async, distributed, deadline-driven.',
                'alt' => 'Team first design icon for Suave CRM collaboration platform',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected static function modules(): array
    {
        $raw = [
            ['id' => 'project', 'name' => 'Project Module', 'icon' => 'assets/product/module-project-icon.png', 'badge' => 'End-to-end project visibility', 'image' => 'assets/product/module-feature.jpg', 'description' => 'Manage projects from kickoff to delivery. Track clients, deadlines, milestones, and team assignments in one Kanban-powered workspace.', 'highlights' => ['Client-linked projects', 'Milestone tracking', 'Kanban & List views', 'Role-based access']],
            ['id' => 'task', 'name' => 'Task Module', 'icon' => 'assets/product/module-task-icon.png', 'badge' => 'Stay on top of every deliverable', 'image' => 'assets/product/module-feature.jpg', 'description' => 'Break work into actionable tasks, assign owners, set priorities, and track progress across your entire organization.', 'highlights' => ['Priority tagging', 'Due date reminders', 'Team assignments', 'Status tracking']],
            ['id' => 'attendance', 'name' => 'Attendance Module', 'icon' => 'assets/product/module-attendance-icon.png', 'badge' => 'Clock-in made effortless', 'image' => 'assets/product/workspace.jpg', 'description' => 'Track attendance, shifts, and working hours with real-time dashboards and automated reporting for HR teams.', 'highlights' => ['Shift management', 'Leave balance', 'Working hours', 'Attendance reports']],
            ['id' => 'holiday', 'name' => 'Holiday Module', 'icon' => 'assets/product/module-holiday-icon.png', 'badge' => 'Plan time off with clarity', 'image' => 'assets/product/workspace.jpg', 'description' => 'Manage company holidays, team calendars, and leave policies in one centralized system everyone can trust.', 'highlights' => ['Holiday calendar', 'Leave policies', 'Team availability', 'Auto-approvals']],
            ['id' => 'messenger', 'name' => 'Messenger Module', 'icon' => 'assets/product/module-messenger-icon.png', 'badge' => 'Communicate without context-switching', 'image' => 'assets/product/module-feature.jpg', 'description' => 'Built-in team messaging tied to projects and tasks — no more jumping between Slack and your project tools.', 'highlights' => ['Project channels', 'Direct messages', 'File sharing', 'Mention alerts']],
            ['id' => 'ai-chat', 'name' => 'AI Chat Module', 'icon' => 'assets/product/module-ai-chat-icon.png', 'badge' => 'Your intelligent assistant', 'image' => 'assets/product/module-feature.jpg', 'description' => 'Ask questions, generate reports, summarize meetings, and get smart suggestions — all powered by AI built into every module.', 'highlights' => ['Report generation', 'Smart summaries', 'Data insights', 'Natural language queries']],
            ['id' => 'comment', 'name' => 'Comment Module', 'icon' => 'assets/product/module-comment-icon.png', 'badge' => 'Feedback where work happens', 'image' => 'assets/product/workspace.jpg', 'description' => 'Threaded comments on tasks, projects, and documents keep conversations contextual and searchable.', 'highlights' => ['Threaded replies', '@mentions', 'Activity feed', 'Searchable history']],
            ['id' => 'attachment', 'name' => 'Attachment Module', 'icon' => 'assets/product/module-attachment-icon.png', 'badge' => 'Files at your fingertips', 'image' => 'assets/product/module-feature.jpg', 'description' => 'Upload, organize, and share files directly within projects and tasks with version control and access permissions.', 'highlights' => ['Version control', 'Access permissions', 'Preview support', 'Cloud storage']],
            ['id' => 'daily-work', 'name' => 'Daily Work Record', 'icon' => 'assets/product/module-daily-work-icon.png', 'badge' => 'Track daily output', 'image' => 'assets/product/workspace.jpg', 'description' => 'Log daily work activities, track time spent on tasks, and generate productivity reports for managers.', 'highlights' => ['Daily logs', 'Time tracking', 'Productivity reports', 'Manager dashboards']],
            ['id' => 'invoice', 'name' => 'Invoice Module', 'icon' => 'assets/product/module-invoice-icon.png', 'badge' => 'Bill clients with confidence', 'image' => 'assets/product/module-feature.jpg', 'description' => 'Create, send, and track invoices linked to projects and timesheets. Get paid faster with automated reminders.', 'highlights' => ['Project-linked billing', 'Payment tracking', 'Auto reminders', 'PDF export']],
        ];

        return array_map(static function (array $module): array {
            $module['icon'] = asset($module['icon']);
            $module['image'] = asset($module['image']);
            $module['alt'] = $module['name'].' module icon for Suave CRM software platform';

            return $module;
        }, $raw);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected static function pricingPlans(): array
    {
        return [
            [
                'name' => 'Free',
                'description' => 'Perfect for small teams getting started',
                'custom' => false,
                'features' => ['Up to 10 users', 'Project & Task Modules', 'Attendance & Holiday', 'Basic Messenger', '5 GB storage', 'Email support'],
                'cta' => 'Start 3 week trial',
                'featured' => false,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Custom setup for large organizations',
                'custom' => true,
                'features' => ['Unlimited users', 'All 12 Modules', 'Dedicated AI model', 'SSO & SAML', 'Unlimited storage', '24/7 dedicated support', 'Custom integrations'],
                'cta' => 'Contact Sales',
                'featured' => false,
            ],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, description: string, alt: string}>
     */
    protected static function productivityFeatures(): array
    {
        $items = [
            ['icon' => 'assets/product/module-comment-icon.png', 'title' => 'Two-way synchronization', 'description' => 'Integrate your task tracker with GitHub to sync changes instantly.'],
            ['icon' => 'assets/product/module-attachment-icon.png', 'title' => 'Private tasks', 'description' => 'Integration and management of multiple data repositories effectively.'],
            ['icon' => 'assets/product/module-daily-work-icon.png', 'title' => 'Multiple repositories', 'description' => 'Organize multiple projects for more effective planning and collaboration.'],
            ['icon' => 'assets/product/feature-icon-milestone.svg', 'title' => 'Milestone migration', 'description' => 'Seamless migration of key project milestones between repositories.'],
            ['icon' => 'assets/product/module-attendance-icon.png', 'title' => 'Track progress', 'description' => 'Keep track of GitHub contributions and changes within your workspace.'],
            ['icon' => 'assets/product/module-project-icon.png', 'title' => 'Advanced filtering', 'description' => 'Precise project data search with advanced filtering capabilities.'],
        ];

        return array_map(static function (array $item): array {
            $item['icon'] = asset($item['icon']);
            $item['alt'] = $item['title'].' productivity feature icon for Suave CRM';

            return $item;
        }, $items);
    }

    /**
     * @return array<int, array{icon: string, title: string, description: string, alt: string}>
     */
    protected static function principles(): array
    {
        $items = [
            ['icon' => 'assets/product/module-comment-icon.png', 'title' => 'People first', 'description' => 'Every decision starts with the teams who use the product daily - clarity over clutter, always.'],
            ['icon' => 'assets/product/module-invoice-icon.png', 'title' => 'Secure by design', 'description' => 'Each organization runs in an isolated workspace with encryption in transit and strict access controls.'],
            ['icon' => 'assets/product/module-attendance-icon.png', 'title' => 'Fast & reliable', 'description' => 'A modern stack tuned for speed, so your team spends time on work — not on waiting.'],
            ['icon' => 'assets/product/module-messenger-icon.png', 'title' => 'Built to evolve', 'description' => 'We ship continuously and design every module to grow with your organization.'],
        ];

        return array_map(static function (array $item): array {
            $item['icon'] = asset($item['icon']);
            $item['alt'] = $item['title'].' principle icon for Suave CRM platform';

            return $item;
        }, $items);
    }

    /**
     * @return array<int, array{image: string, title: string, description: string, href: string, alt: string}>
     */
    protected static function partnerCards(): array
    {
        $items = [
            ['image' => 'assets/product/partner-trust-card.jpg', 'title' => 'The company you can trust', 'description' => 'Suave Creators is built for security, reliability, and transparency, meeting leading compliance standards.', 'href' => route('about-us')],
            ['image' => 'assets/product/partner-support-card.jpg', 'title' => 'Expert support, at every stage', 'description' => 'Suave Creators Success and Services teams give you direct access to the experts behind the product.', 'href' => route('contact-us')],
            ['image' => 'assets/product/hero-shape.png', 'title' => 'The AI Agent Blueprint', 'description' => 'A practical guide to launching and scaling AI in customer service, built from real-world experience and best practices.', 'href' => route('blogs')],
        ];

        return array_map(static function (array $item): array {
            $item['image'] = asset($item['image']);
            $item['alt'] = $item['title'].' partner card for Suave CRM software development';

            return $item;
        }, $items);
    }

    /**
     * @return array<int, array{icon: string, href: string, label: string, external: bool}>
     */
    protected static function socialLinks(): array
    {
        return [
            ['icon' => 'fa-solid fa-link', 'href' => route('contact-us'), 'label' => 'Contact', 'external' => false],
            ['icon' => 'fa-brands fa-facebook-f', 'href' => 'https://www.facebook.com/share/1Zt4fotyAa/', 'label' => 'Facebook', 'external' => true],
            ['icon' => 'fa-brands fa-instagram', 'href' => 'https://www.instagram.com/suavecreators/?igsh=MWRscWJoZXJrNG10cw%3D%3D#', 'label' => 'Instagram', 'external' => true],
            ['icon' => 'fa-brands fa-linkedin-in', 'href' => 'https://www.linkedin.com/company/suave-creators/', 'label' => 'LinkedIn', 'external' => true],
        ];
    }
}
