<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class ServiceSupport
{
    use MapsDesignAssets;

    /** @var array<int, string> */
    public const SLUGS = [
        'web-development-services',
        'custom-crm-development',
        'enterprise-software-solutions',
        'e-commerce-development',
        'ui-ux-design-services',
        'ai-solutions',
    ];

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        return [
            'techStack' => AboutSupport::techStack(),
            'expertiseItems' => self::expertiseItems(),
            'servicesData' => self::servicesData(),
            'offshoreSlides' => self::offshoreSlides(),
            'techCards' => self::techCards(),
            'processCards' => self::processCards(),
            'faqs' => self::faqs(),
            'articles' => self::articles(),
            'connectCta' => [
                'eyebrow' => 'Ready to Start Your Project?',
                'title' => 'Are you Ready to Start Your Project?',
                'description' => 'As the best development company, we help you to develop your next digital product. Get Innovative and advanced solutions with us and see the quick growth.',
                'primaryLabel' => "Let's Connect to Discuss",
            ],
            'consultation' => [
                'backgroundImage' => 'assets/background/work-with-us-bg.webp',
                'eyebrow' => 'Ready to Start Your Project?',
                'title' => 'Are you Ready to Start Your Project?',
                'description' => 'As the best development company, we help you to develop your next digital product. Get Innovative and advanced solutions with us and see the quick growth.',
                'ctaLabel' => "Let's Connect to Discuss",
                'solo' => false,
                'showPeople' => false,
            ],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string, 4: string}>
     */
    public static function expertiseItems(): array
    {
        return [
            ['assets/portfolio/project-analysis-dashboard.png', 'Project analysis', 'Research and strategy', '#4C24F4', '#F0EAFF', 'Project analysis dashboard for Suave Creators web development services'],
            ['assets/media/build-strategy-visual.png', 'Build strategy', 'Wireframe and design', '#1873E7', '#EAF5FC', 'Build strategy visual for Suave Creators software design process'],
            ['assets/media/launch-live-visual.png', 'Launch and live', 'Development and scale', '#0F968E', '#E8F8F6', 'Launch and live product visual for Suave Creators development services'],
            ['assets/brand/maintenance-mark-logo.png', 'Maintenance', 'Maintaining strong', '#FA6811', '#FFF0E7', 'Maintenance support mark for Suave Creators software services'],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string, 4: string, 5: string}>
     */
    public static function servicesData(): array
    {
        return [
            ['assets/icons/service-icon-1.svg', 'Web Development Services', 'Explore our top-notch web development services to get the best possible digital solution to enhance user interaction and scale seamlessly as your needs grow.', 'Explore Web Development', route('service.show', ['slug' => 'web-development-services']), 'blue'],
            ['assets/icons/service-icon-2.svg', 'Enterprise Software Solutions', 'We offer the best and industry-specific Enterprise Software Solutions for organisations to manage their work more conveniently. Get a secure and scalable solution with us.', 'Explore Enterprise Solutions', route('service.show', ['slug' => 'enterprise-software-solutions']), 'blue'],
            ['assets/icons/service-icon-3.svg', 'UI/UX Design Services', 'UI/UX Designs help you to stand out in the competition. We are experts in front-end design, optimising custom code to deliver the best UI/UX design services.', 'See UI/UX Services', route('services'), 'blue'],
            ['assets/icons/service-icon-4.svg', 'Custom CRM Development', 'Suave Creators develops custom-tailored CRM Solutions, implementing application development software features and functionalities that drive businesses forward.', 'Learn More About CRM', route('service.show', ['slug' => 'custom-crm-development']), 'blue'],
            ['assets/icons/service-icon-5.svg', 'E-commerce Development', 'Choosing e-commerce development with us is the best option for you. Try our best development services and get a reliable solution for your digital business needs.', 'Explore E-commerce Services', route('service.show', ['slug' => 'e-commerce-development']), 'blue'],
            ['assets/icons/service-icon-6.svg', 'AI Solutions', 'With this fast technology world, everyone needs an AI solution. We embed an AI solution with all of our software solutions. AI helps businesses to make it more secure, advanced, and productive.', 'Explore AI Services', route('services'), 'blue'],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: array<int, string>, 4: string}>
     */
    public static function offshoreSlides(): array
    {
        return [
            [
                'assets/media/developers-collaborating-code-review.webp',
                'End-to-End Development Expertise',
                'With all of our projects, we always provide end-to-end development services. By leveraging our global young talent and systematic resource allocation, we provide the best and competitive pricing that helps you to get expert solutions and optimise your development budget.',
                ['SEO', 'Mobile', 'First Performance'],
                'Offshore development team reviewing custom software code together',
            ],
            [
                'assets/media/seo-infographic-on-imac.webp',
                'SEO-Optimisation and Performance',
                'SEO optimization and high performance are the needs of every website and application nowadays. All of our solutions perform better and follow Search engine algorithms so that they easily gain good visibility on Google soon.',
                ['UI/UX', 'Research', 'Prototyping'],
                'SEO optimisation strategy on screen for high performance websites',
            ],
            [
                'assets/media/financial-dashboard-laptop-collaboration.webp',
                'Global and Scalable Security',
                'Our solutions are built to grow with your business. Whether you\'re a startup expanding into new markets or an enterprise business managing high volumes, we design platforms that scale without performance issues.',
                ['SEO', 'Mobile', 'First Performance'],
                'Secure scalable analytics dashboard monitored by an enterprise software team',
            ],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string}>
     */
    public static function techCards(): array
    {
        return [
            ['assets/icons/tech/shopify-technology-icon.png', 'Shopify & WooCommerce', 'We suggest CRM according to the clients\' needs. We develop websites for Shopify and WooCommerce for your e-commerce websites.', '#7AB55C'],
            ['assets/icons/tech/react-technology-icon.png', 'React & Angular', 'We built websites on React & Angular to deliver high performance and a strong security system.', '#149ECA'],
            ['assets/icons/tech/php-technology-icon.png', 'Laravel & PHP', 'We specialize in building web applications using the PHP programming language and the Laravel framework.', '#999999'],
            ['assets/icons/tech/nodejs-technology-icon.png', 'Node.js', 'We use Node.js to build real-time apps, high-performance results, robust and mobile solutions, etc.', '#68A063'],
            ['assets/icons/tech/wordpress-technology-icon.png', 'WordPress', 'A best and reliable easy-to-use CMS solution for all types of businesses with all SEO capabilities.', '#21759B'],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, text: string}>
     */
    public static function processCards(): array
    {
        return [
            ['icon' => 'fa-solid fa-magnifying-glass-chart', 'title' => 'Discovery Phase', 'text' => 'Before starting anything, we do deep research and define the fundamental features of your future product.'],
            ['icon' => 'fa-solid fa-route', 'title' => 'Strategy Development', 'text' => 'We craft a transparent roadmap for success. Our professional crew defines the project planning, sets deadlines, and chooses the right technologies to bring your vision to life.'],
            ['icon' => 'fa-solid fa-code', 'title' => 'Implementation', 'text' => 'Our expert designers collaborate to transform strategy into a fully functional, high-performing product and deliver you the best possible solution.'],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    public static function faqs(): array
    {
        return [
            ['question' => 'Do you work with international clients?', 'answer' => 'Yes, Suave Creators works with international clients, including the UK, USA, Canada, Australia, and all countries across the globe.'],
            ['question' => 'How do you ensure SEO-friendly development in your services?', 'answer' => 'We have the best team of seo experts who sit with the developer and do a complete audit step-by-step, and it will cover all technical and on-page aspects.'],
            ['question' => 'What industries do you serve?', 'answer' => 'We specialise in offering solutions for all types of industries, like healthcare, education, banking, e-commerce, and logistics. Each solution is tailored to the industry standards, compliance needs, and customer experience.'],
            ['question' => 'What is the typical project timeline?', 'answer' => 'It totally depends on the project complexity. Sometimes it will take 3 months or sometimes more than 6 months to 1 year.'],
            ['question' => 'Do you offer post-launch support and maintenance?', 'answer' => "Yes, of course, we always do post-launch support and maintenance as per the client's requirements."],
            ['question' => 'Why should we choose Suave Creators for our digital projects?', 'answer' => 'Suave Creators is a team of young talent who always work under timelines and deliver the best possible results.'],
        ];
    }

    /**
     * @return array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public static function articles(): array
    {
        return BlogSupport::articleCards(3);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function service(string $slug): ?array
    {
        if (! in_array($slug, self::SLUGS, true)) {
            return null;
        }

        $path = self::dataPath('services/'.$slug.'.php');

        if (! is_file($path)) {
            return null;
        }

        /** @var array<string, mixed> $service */
        $service = include $path;

        return self::assetizeDesignData(self::mapDesignData($service));
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $service = self::service($slug);

        if ($service === null) {
            abort(404);
        }

        $posts = BlogSupport::posts()->take(3)->values()->all();
        $bodyImage = (string) ($service['bodyImage'] ?? '');
        $bodyBg = (string) ($service['bodyBg'] ?? '');
        $useBodyImageLayout = $bodyImage !== '';
        $introLinkUrl = (string) ($service['introLinkUrl'] ?? '');

        if ($introLinkUrl === '' || $introLinkUrl === '/services' || $introLinkUrl === '/services/') {
            $service['introLinkUrl'] = route('services');
        } else {
            $service['introLinkUrl'] = self::resolveInternalHref($introLinkUrl);
        }

        return [
            'service' => $service,
            'seoTitle' => (string) ($service['pageTitle'] ?? 'Service | Suave Creators'),
            'seoDescription' => (string) ($service['pageDescription'] ?? 'Suave Creators service details.'),
            'seoOgTitle' => (string) ($service['ogTitle'] ?? $service['pageTitle'] ?? ''),
            'seoOgDescription' => (string) ($service['ogDescription'] ?? $service['pageDescription'] ?? ''),
            'seoFaqs' => array_values(array_filter(
                array_map(static function (array $faq): array {
                    return [
                        'question' => (string) ($faq['question'] ?? ''),
                        'answer' => (string) ($faq['answer'] ?? ''),
                    ];
                }, is_array($service['faqs'] ?? null) ? $service['faqs'] : []),
                static fn (array $faq): bool => $faq['question'] !== '' && $faq['answer'] !== '',
            )),
            'bannerBg' => asset(self::mapDesignPath((string) ($service['bannerBg'] ?? '/assets/background/service-banner-bg.webp'))),
            'introBg' => asset(self::mapDesignPath('/assets/background/technology-section-bg.png')),
            'collabBackground' => asset(self::mapDesignPath((string) ($service['collabBackground'] ?? '/assets/media/collaboration-back-visual.png'))),
            'collabImage' => asset(self::mapDesignPath((string) ($service['collabImage'] ?? '/assets/media/collaboration-front-visual.png'))),
            'marqueeIcons' => array_map(
                fn (mixed $icon): string => asset(is_string($icon) ? self::mapDesignPath($icon) : ''),
                $service['marqueeIcons'] ?? self::defaultMarqueeIcons(),
            ),
            'portfolioItems' => self::mapPortfolioItems($service['portfolioImages'] ?? self::defaultPortfolioImages()),
            'introStats' => self::introStats(),
            'industryCards' => self::mapIndustryCards($service['industries'] ?? []),
            'standoutCards' => self::mapStandoutCards($service['standoutCards'] ?? []),
            'processSteps' => self::mapProcessSteps($service['processSteps'] ?? []),
            'articles' => self::mapArticles($posts),
            'caseStudies' => CaseStudySupport::forService($slug, 6),
            'techStack' => AboutSupport::techStack(),
            'webDevLayoutSlugs' => self::SLUGS,
            'isWebDevelopmentService' => in_array($slug, self::SLUGS, true),
            'capabilitiesAsSlider' => ! empty($service['capabilitiesAsSlider']),
            'capabilitiesGridColumns' => (int) ($service['capabilitiesGridColumns'] ?? 3),
            'useBodyImageLayout' => $useBodyImageLayout,
            'bodySectionStyle' => $useBodyImageLayout
                ? "--service-body-image: url('".e($bodyImage)."');"
                : ($bodyBg !== '' ? "background-image: url('".e($bodyBg)."');" : ''),
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string, 4: string}>
     */
    public static function introStats(): array
    {
        return [
            ['50+', 'Projects Delivered', 'Successfully delivered websites, software, CRMs, mobile apps, and digital solutions.', 'assets/icons/projects-delivered-stat-icon.svg', '#4C24F4'],
            ['10+', 'Years Experience', 'Building scalable digital products with modern technologies.', 'assets/icons/years-experience-stat-icon.svg', '#1873E7'],
            ['98%', 'Client Satisfaction', 'Focused on quality, transparency, and long-term partnerships.', 'assets/icons/funding-secured-stat-icon.svg', '#0C7A73'],
            ['15+', 'Expert Team', '15+ passionate developers and management specialists ready to build with you.', 'assets/icons/expert-team-stat-icon.svg', '#C4520D'],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $industries
     * @return array<int, array{image: string, title: string, text: string, href: string}>
     */
    protected static function mapIndustryCards(array $industries): array
    {
        return array_values(array_map(static function (array $ind): array {
            return [
                'image' => (string) ($ind['icon'] ?? ''),
                'title' => (string) ($ind['title'] ?? ''),
                'text' => (string) ($ind['desc'] ?? ''),
                'href' => self::resolveInternalHref((string) ($ind['link'] ?? '')),
            ];
        }, $industries));
    }

    /**
     * @param  array<int, array<string, mixed>>  $cards
     * @return array<int, array{image: string, title: string, text: string, step: string}>
     */
    protected static function mapStandoutCards(array $cards): array
    {
        return array_values(array_map(static function (array $card): array {
            return [
                'image' => (string) ($card['icon'] ?? ''),
                'title' => (string) ($card['title'] ?? ''),
                'text' => (string) ($card['desc'] ?? ''),
                'step' => (string) ($card['step'] ?? ''),
            ];
        }, $cards));
    }

    protected static function resolveInternalHref(string $href): string
    {
        $href = trim($href);

        if ($href === '' || $href === '#') {
            return $href;
        }

        if (str_starts_with($href, 'http://') || str_starts_with($href, 'https://') || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:')) {
            return $href;
        }

        $path = (string) str($href)->before('#')->trim('/');

        return match (true) {
            $path === 'services' => route('services'),
            $path === 'contact-us' => ContactSupport::demoHref(),
            $path === 'blogs' => route('blogs'),
            str_starts_with($path, 'industries/') => route('industry.show', ['slug' => (string) str($path)->after('industries/')]),
            str_starts_with($path, 'services/') => route('service.show', ['slug' => (string) str($path)->after('services/')]),
            str_starts_with($path, 'service/') => route('service.show', ['slug' => (string) str($path)->after('service/')]),
            default => $href,
        };
    }

    /**
     * @param  array<int, array<string, mixed>>  $steps
     * @return array<int, array{step: string, icon: string, title: string, desc: string}>
     */
    protected static function mapProcessSteps(array $steps): array
    {
        $defaultIcons = [
            'assets/media/industry-discovery-strategy.svg',
            'assets/media/industry-design-development.svg',
            'assets/media/industry-goals.svg',
            'assets/media/industry-multi-channel-communication.svg',
            'assets/media/industry-launch-growth.svg',
        ];

        return array_values(array_map(static function (array $step, int $index) use ($defaultIcons): array {
            return [
                'step' => (string) ($step['step'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)),
                'icon' => (string) ($step['icon'] ?? $defaultIcons[$index % count($defaultIcons)]),
                'title' => (string) ($step['title'] ?? ''),
                'desc' => (string) ($step['desc'] ?? ''),
            ];
        }, $steps, array_keys($steps)));
    }

    /**
     * @param  array<int, array<string, mixed>>  $posts
     * @return array<int, array<string, string>>
     */
    protected static function mapArticles(array $posts): array
    {
        return array_values(array_map(static function (array $post): array {
            return [
                'title' => (string) ($post['title'] ?? ''),
                'excerpt' => (string) ($post['short_description'] ?? ''),
                'image' => (string) ($post['image'] ?? ''),
                'alt' => (string) ($post['title'] ?? ''),
                'date' => (string) ($post['published_label'] ?? ''),
                'datetime' => (string) ($post['published_date'] ?? ''),
                'author' => (string) ($post['author_name'] ?? 'Suave Creators'),
                'url' => (string) ($post['url'] ?? route('blogs')),
            ];
        }, $posts));
    }

    /**
     * @return array<int, string>
     */
    protected static function defaultMarqueeIcons(): array
    {
        return [
            '/assets/media/service-process-step-1.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-2.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-3.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-4.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected static function defaultPortfolioImages(): array
    {
        return [
            '/assets/portfolio/swastik-culture-hub-website.webp',
            '/assets/portfolio/mavan-growth-agency-website.webp',
            '/assets/portfolio/sales-automation-project-dashboard.webp',
            '/assets/portfolio/hubops-software-company-website.webp',
            '/assets/portfolio/suave-outreach-crm-laptop.webp',
            '/assets/portfolio/ematrics-ai-sales-website.webp',
        ];
    }

    /**
     * @param  array<int, mixed>  $images
     * @return array<int, array{image: string, url: string, alt: string, external: bool}>
     */
    protected static function mapPortfolioItems(array $images): array
    {
        $byBasename = [];

        foreach (HomeSupport::portfolioShowcaseProjects() as $project) {
            $basename = basename((string) ($project['image'] ?? ''));

            if ($basename !== '') {
                $byBasename[$basename] = $project;
            }
        }

        $items = [];

        foreach ($images as $index => $image) {
            if (! is_string($image) || $image === '') {
                continue;
            }

            $mapped = self::mapDesignPath($image);
            $basename = basename($mapped);
            $project = $byBasename[$basename] ?? null;
            $alt = is_array($project) && is_string($project['alt'] ?? null)
                ? (string) $project['alt']
                : 'Suave Creators project showcase '.($index + 1);
            $url = is_array($project) && is_string($project['url'] ?? null)
                ? (string) $project['url']
                : '';

            $items[] = [
                'image' => asset($mapped),
                'url' => $url,
                'alt' => $alt,
                'external' => is_array($project) ? (bool) ($project['external'] ?? false) : false,
            ];
        }

        return $items;
    }
}
