<?php

namespace App\Support\Frontend;

class IndustrySupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'latestPosts' => array_slice(BlogSupport::posts(), 0, 3),
            'articles' => array_map(static function (array $post): array {
                return [
                    'title' => $post['title'],
                    'excerpt' => $post['short_description'],
                    'image' => $post['image'],
                    'alt' => $post['title'],
                    'date' => $post['published_label'],
                    'datetime' => $post['published_date'],
                    'author' => $post['author_name'],
                    'url' => $post['url'] ?? route('blogs'),
                ];
            }, array_slice(BlogSupport::posts(), 0, 3)),
            'techStack' => AboutSupport::techStack(),
            'portfolioHeroImages' => self::portfolioHeroImages(),
            'aiSolutions' => self::aiSolutions(),
            'expertiseIndustries' => self::expertiseIndustries(),
            'expertiseDefault' => 0,
            'whySuaveServices' => self::whySuaveServices(),
            'processItems' => self::processItems(),
            'faqs' => self::faqs(),
            'testimonials' => HomeSupport::testimonials(),
            'connectCta' => self::connectCta(),
            'consultation' => self::consultation(),
            'faq' => self::faq(),
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function portfolioHeroImages(): array
    {
        return [
            'assets/media/portfolioimg1.webp',
            'assets/media/portfolioimg2.webp',
            'assets/media/portfolioimg3.webp',
            'assets/media/portfolioimg4.webp',
            'assets/media/portfolioimg5.webp',
            'assets/media/portfolioimg6.webp',
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: array<int, string>, 4: string}>
     */
    public static function aiSolutions(): array
    {
        return [
            [
                'IT & Software Solutions for Startups',
                'Suave Creators collaborate with IT startups worldwide, providing IT solutions & services to build, boost, and scale products across industries.',
                'assets/media/ai-service-visual-1.webp',
                ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
                route('industry.show', ['slug' => 'it-software-solutions-for-startups']),
            ],
            [
                'Healthcare Software Development',
                'Our Healthcare Software Development Services cover designing and developing software for better hospital management and improved efficiency.',
                'assets/media/ai-service-visual-2.webp',
                ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
                route('industry.show', ['slug' => 'healthcare']),
            ],
            [
                'Education & E-learning Platforms',
                'We create end-to-end custom e-learning platforms with digital resources and tools that make education systems easier to manage.',
                'assets/media/ai-service-visual-3.webp',
                ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
                route('industry.show', ['slug' => 'education-elearning-platforms']),
            ],
            [
                'Retail & E-commerce Solutions',
                'We offer end-to-end retail & e-commerce software solutions with expert knowledge across all stages of the business cycle.',
                'assets/media/ai-service-visual-4.webp',
                ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
                route('industry.show', ['slug' => 'retail-ecommerce-solutions']),
            ],
            [
                'Finance & Banking Software Development',
                'We provide software development for the financial and banking sector, focusing on custom web and mobile apps for startups and enterprises.',
                'assets/media/ai-service-visual-5.webp',
                ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
                route('industry.show', ['slug' => 'finance-banking-software-development']),
            ],
            [
                'Logistics & Supply Chain Apps',
                'We specialise in logistics and transportation management applications that enhance overall operational efficiency.',
                'assets/media/ai-service-visual-6.webp',
                ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
                route('industry.show', ['slug' => 'logistics-supply-chain-apps']),
            ],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: array<int, string>, 4: string, 5: string}>
     */
    public static function expertiseIndustries(): array
    {
        return [
            [
                'Finance',
                'We Develop Smart Finance Solutions',
                'Get a smart AI solution with us; we develop smart Finance and Banking solutions for all smart or large organisations. We have the solution for you.',
                ['Fintech Design', 'App Development', 'Banking UX', 'Wealth Branding'],
                'assets/media/finance-banner.webp',
                'fa-solid fa-building-columns',
            ],
            [
                'Education',
                'Empowering Learning Through Digital Innovation',
                'We transform traditional education into AI tech and digital experience. From e-Learning to virtual classrooms, we create smart solutions for all educational institutions and organisations.',
                ['E-learning', 'Portal Design', 'Course Branding', 'LMS Integration'],
                'assets/media/education-banner.webp',
                'fa-solid fa-graduation-cap',
            ],
            [
                'Real Estate',
                'Building Digital Foundations for Real Estate Success',
                'Let\'s drive more sales and strong visibility with smart websites and property management software. Our software connects buyers with their dream home.',
                ['RE Branding', 'CRE Branding', 'RE Website Design', 'RE Fund Luxury Branding', 'RE Development', 'RE Agent Solutions'],
                'assets/media/insight-future-work.jpg',
                'fa-solid fa-house',
            ],
            [
                'Healthcare',
                'Transform hospital care with smart AI Solutions',
                'A smart solution is served for the hospital and healthcare institutions. With our software, you streamline operations, refine patient experience, and secure telehealth platforms.',
                ['Clinic Branding', 'Telemedicine', 'Healthcare UX', 'SEO for Doctors'],
                'assets/media/industry-healthcare-visual.jpg',
                'fa-solid fa-heart-pulse',
            ],
            [
                'E-commerce',
                'Enjoy the best Shopping experience',
                'Our professional, skilled team provides custom eCommerce solutions that integrate seamlessly with existing systems and offer valuable data for optimisation.',
                ['UI/UX', 'Shopify', 'SEO', 'Performance Marketing'],
                'assets/media/ecommerce-banner.webp',
                'fa-solid fa-cart-shopping',
            ],
            [
                'Technology & Startups',
                'Reliable and Scalable solution for Technology',
                'We deliver scalable tech solutions to build smart, robust and future-ready custom smart solutions. We develop digital products for your business or organisation.',
                ['MVP Design', 'Brand Identity', 'Pitch Deck Design', 'Product Strategy'],
                'assets/media/it-solutions-banner.webp',
                'fa-solid fa-rocket',
            ],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string, 4: string}>
     */
    public static function whySuaveServices(): array
    {
        return [
            ['industry-goals.svg', '01 - Goals', 'Industry Goals', 'All businesses, whether small or large, have unique challenges; that\'s why we begin by working deep into your industry-specific objectives. Our mission is to build strong software solutions that reflect your individuality and growth ambitions.', 'blue'],
            ['industry-specific-solutions.svg', '02 - Solutions', 'Industry-Specific Solutions', 'We believe in delivering industry-specific solutions in today\'s fast-changing landscape. We work on global technology and groundbreaking innovations to provide future-ready blends for all types of industries.', 'orange'],
            ['industry-user-centric-design.svg', '03 - Design', 'User-Centric Design', 'Our software design ideology revolves around creating the best software that is visually appealing, intuitive, and easy to manage. You will enjoy a smooth workflow and a great user experience.', 'cyan'],
            ['evaluating-industry-software.svg', '04 - Build', 'Constructing Industry Softwares', 'With our professional team, we meticulously design and implement each part of your solution with unmatched precision. Our testing phase gives you a guarantee for a seamless, scalable and effective software system.', 'mint'],
            ['customer-support-ticketing.svg', '05 - Support', 'Customer Support & Ticketing', 'Our professional support team will track support tickets and help you to organize everything and be on time. With this, our team can provide reliable and professional support at all times.', 'rose'],
            ['industry-multi-channel-communication.svg', '06 - Connect', 'Multi-Channel Communication', 'Our team will give you support through your preferred channels, including social media, live chat support, or email. Giving communication options is one of the best options ever.', 'amber'],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, desc: string, image: string, alt: string}>
     */
    public static function processItems(): array
    {
        return [
            [
                'icon' => 'discovery',
                'title' => 'Discovery & Strategy',
                'desc' => 'We understand your goals and challenges and then work on the discovery and strategy stage. By understanding your goals we make a clear product roadmap.',
                'image' => 'assets/media/portfolio-1.png',
                'alt' => 'Discovery and strategy planning session for Suave Creators industry solutions',
            ],
            [
                'icon' => 'design',
                'title' => 'Design & Development',
                'desc' => 'Our skilled team understands the roadmap and works on the design and development stage. We turn your ideas into robust functionalities.',
                'image' => 'assets/media/portfolio-2.png',
                'alt' => 'Design and development workspace for industry software',
            ],
            [
                'icon' => 'launch',
                'title' => 'Launch & Growth',
                'desc' => 'Once your product is live, we continue to optimize, scale, and enhance it. A long term growth is provided from our end.',
                'image' => 'assets/media/portfolio-3.png',
                'alt' => 'Product launch and growth metrics for industry platforms',
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
                'question' => 'What is the key driver of the global software market?',
                'answer' => 'The software development industry\'s growth complicates the task of operating a business in changing winds. At the same time, however, a zest for serving the audience\'s needs in a new and better way is the key driver of new projects\' appearance.',
            ],
            [
                'question' => 'How big is the software development industry these days?',
                'answer' => 'According to the latest updates, the global developer market shows a balanced increase from 26.5 million to 28.7 million specialists.',
            ],
            [
                'question' => 'What is the biggest software market for the time being?',
                'answer' => 'Enterprise software is the one that owns the largest share of the overall software market projects. Translating this statement into numbers, in 2021, it made over $200bn in revenue, despite COVID-19 and economic fluctuations.',
            ],
            [
                'question' => 'Why is the industry of software development so important worldwide?',
                'answer' => 'Software development is important globally because of its scalability. The new and upgraded software increases productivity and reduces labour costs at once.',
            ],
            [
                'question' => 'Do you offer post-launch support and maintenance?',
                'answer' => 'Yes, of course, we always do post-launch support and maintenance as per the client\'s requirements.',
            ],
            [
                'question' => 'Why should we choose Suave Creators for our digital projects?',
                'answer' => 'Suave Creators is a team of young talent who always work under timelines and deliver the best possible results.',
            ],
        ];
    }

    /**
     * @return array{eyebrow: string, title: string, description: string, titleId: string, primaryLabel: string, sectionClass: string}
     */
    public static function connectCta(): array
    {
        return [
            'eyebrow' => 'Ready to Start Your Project?',
            'title' => 'Kickstart Your Dream Project With Us',
            'description' => 'With our best industry solution development services, we take ownership of your solution and process, so you never feel alone on your journey. Let\'s collaborate with us for your next software solution.',
            'titleId' => 'industry-cta-title',
            'primaryLabel' => 'Turn Your Vision Into Reality',
            'sectionClass' => 'full-bleed smart-together-cta py-4 sm:py-6',
        ];
    }

    /**
     * @return array{solo: bool, showPeople: bool, title: string, description: string, ctaLabel: string}
     */
    public static function consultation(): array
    {
        return [
            'solo' => true,
            'showPeople' => false,
            'title' => 'Get the Best Solution for your<br class="hidden sm:block"> Organisation with us',
            'description' => 'We are always happy to serve you the best and smart industry solution. With Suave Creators, we bring the latest technology and benefit from experts who are eager to share their knowledge.',
            'ctaLabel' => 'Get a Free Quote',
        ];
    }

    /**
     * @return array{eyebrow: string, description: string, ctaLabel: string}
     */
    public static function faq(): array
    {
        return [
            'eyebrow' => 'Have questions about our Industry Solutions?',
            'description' => 'Here are the most asked questions about industry software and digital solutions.',
            'ctaLabel' => 'Start your Project',
        ];
    }
}
