<?php

namespace App\Support\Frontend;

class AboutSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'stats' => self::stats(),
            'shoreSlides' => self::shoreSlides(),
            'smartModules' => self::smartModules(),
            'coreValues' => self::coreValues(),
            'growthFeatures' => self::growthFeatures(),
            'techStack' => self::techStack(),
            'articles' => array_slice(HomeSupport::articles(), 0, 3),
            'partnerMarqueeItems' => HomeSupport::partnerMarqueeItems(),
        ];
    }

    /**
     * @return array<int, array{end: int, suffix: string, label: string, description: string}>
     */
    public static function stats(): array
    {
        return [
            [
                'end' => 10,
                'suffix' => '+',
                'label' => 'Years of Experience',
                'description' => 'Building scalable digital products with modern technologies.',
            ],
            [
                'end' => 50,
                'suffix' => '+',
                'label' => 'Projects Delivered',
                'description' => 'Successfully delivered websites, software, CRMs, mobile apps, and digital solutions.',
            ],
            [
                'end' => '98',
                'suffix' => '%',
                'label' => 'Client Satisfaction',
                'description' => 'Focused on quality, transparency, and long-term partnerships.',
            ],
            [
                'end' => 15,
                'suffix' => '+',
                'label' => 'Expert Team',
                'description' => '15+ passionate developers and management specialists ready to build with you.',
            ],
        ];
    }

    /**
     * @return array<int, array{image: string, title: string, text: string, tags: array<int, string>, alt: string}>
     */
    public static function shoreSlides(): array
    {
        return [
            [
                'image' => 'assets/media/answer-engine-inspiration-mindmap.webp',
                'title' => 'Innovative & Engaging Process',
                'text' => 'We believe in bringing engagement through the creative efforts at our workplace. Our strategies are uniquely delivered to the clients, which keeps them at bay to converge businesses into better opportunities.',
                'tags' => ['SEO', 'Mobile', 'First Performance'],
                'alt' => 'Creative mindmap shaping an innovative web design and development process',
            ],
            [
                'image' => 'assets/media/conference-table-analytics-whiteboard.webp',
                'title' => 'Research driven results',
                'text' => 'Suave creators always focus on research before proceeding with any project. This helps us in preparing our comprehensive strategy, which results in the brand\'s success with relentless growth.',
                'tags' => ['SEO', 'Mobile', 'First Performance'],
                'alt' => 'Research charts and analytics guiding data driven digital strategy',
            ],
            [
                'image' => 'assets/media/generative-engine-dev-team-coding.webp',
                'title' => 'Optimal Delivery',
                'text' => 'We don\'t just deliver the services, but ensure that our clients are happy with what we are delivering to them. Our approach and strategies mark the excellence in our efforts to provide them with better deliverables.',
                'tags' => ['SEO', 'Mobile', 'First Performance'],
                'alt' => 'Software engineers delivering optimised custom development projects on time',
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, icon: string}>
     */
    public static function smartModules(): array
    {
        return [
            ['label' => 'Holidays', 'icon' => 'fa-solid fa-calendar-days'],
            ['label' => 'Projects', 'icon' => 'fa-solid fa-file-circle-plus'],
            ['label' => 'Logistics', 'icon' => 'fa-solid fa-cube'],
            ['label' => 'AI Chat', 'icon' => 'fa-solid fa-comment-dots'],
            ['label' => 'Tasks', 'icon' => 'fa-solid fa-list-check'],
            ['label' => 'Outreach', 'icon' => 'fa-solid fa-chart-column'],
        ];
    }

    /**
     * @return array<int, array{title: string, text: string, icon: string, alt: string}>
     */
    public static function coreValues(): array
    {
        return [
            [
                'title' => 'Our Vision',
                'text' => 'We aim to enable businesses to stand higher from the rest of the world. To build a responsive and user oriented quality web designing & web development is our foremost capability to assist in the growth of any business.',
                'icon' => 'assets/icons/core-value-icon-1.svg',
                'alt' => 'Suave Creators vision icon for web design and development',
            ],
            [
                'title' => 'Our Mission',
                'text' => 'Our ultimate goal is to provide solutions to our esteemed clients beyond their requirements. We wish to ensure knowledge driven services where they can easily solve the relevant business concerns as per their client\'s requirement.',
                'icon' => 'assets/icons/core-value-icon-2.svg',
                'alt' => 'Suave Creators mission icon for custom software solutions',
            ],
            [
                'title' => 'Our Approach',
                'text' => 'We have a team of mindful & crazy people who love to explore customer-centric solutions for designing & developing websites. We aim to know what the client wants & add value to it with some useful & extra efforts to deliver a high quality service to them.',
                'icon' => 'assets/icons/core-value-icon-3.svg',
                'alt' => 'Suave Creators approach icon for customer-centric web development',
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, text: string, image: string, alt: string}>
     */
    public static function growthFeatures(): array
    {
        return [
            [
                'title' => 'Data-Driven Approach',
                'text' => 'Our data-driven approach utilizes analytics and insights to optimize strategies, enhance user experiences, and drive growth by making informed decisions based on real-time data and trends.',
                'image' => 'assets/media/financial-dashboard-laptop-collaboration.webp',
                'alt' => 'Data-driven analytics approach for digital growth by Suave Creators',
            ],
            [
                'title' => 'Competitive Pricing',
                'text' => 'We offer competitive pricing without compromising quality, ensuring cost-effective solutions tailored to your needs. Get premium digital services that maximize value while staying within your budget.',
                'image' => 'assets/media/competitive-pricing-strategy-cash.webp',
                'alt' => 'Competitive pricing for web development and digital services',
            ],
            [
                'title' => 'Ethical Business Practices',
                'text' => 'We prioritize ethical business practices, ensuring transparency, integrity, and fairness in all our dealings. Our commitment to honesty fosters trust, long-term partnerships, and sustainable business growth.',
                'image' => 'assets/media/diverse-team-data-meeting.webp',
                'alt' => 'Ethical business practices in software development partnerships',
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, src: string, alt: string}>
     */
    public static function techStack(): array
    {
        return [
            ['label' => 'HTML', 'src' => 'assets/icons/tech/html5.svg', 'alt' => 'HTML5 technology logo for Suave Creators web development'],
            ['label' => 'JavaScript', 'src' => 'assets/icons/tech/javascript.svg', 'alt' => 'JavaScript technology logo for Suave Creators software development'],
            ['label' => 'Node.Js', 'src' => 'assets/icons/tech/nodedotjs.svg', 'alt' => 'Node.js technology logo partner of Suave Creators'],
            ['label' => 'Magento', 'src' => 'assets/icons/tech/magento.svg', 'alt' => 'Magento ecommerce technology logo for Suave Creators'],
            ['label' => 'React', 'src' => 'assets/icons/tech/react.svg', 'alt' => 'React technology logo for Suave Creators web applications'],
            ['label' => 'Python', 'src' => 'assets/icons/tech/python.svg', 'alt' => 'Python technology logo for Suave Creators custom software'],
            ['label' => 'Vue.js', 'src' => 'assets/icons/tech/vuedotjs.svg', 'alt' => 'Vue.js technology logo for Suave Creators frontend development'],
            ['label' => 'Angular', 'src' => 'assets/icons/tech/angular.svg', 'alt' => 'Angular technology logo for Suave Creators web development'],
            ['label' => 'CodeIgniter', 'src' => 'assets/icons/tech/codeigniter.svg', 'alt' => 'CodeIgniter PHP framework logo for Suave Creators'],
            ['label' => 'WordPress', 'src' => 'assets/icons/tech/wordpress.svg', 'alt' => 'WordPress CMS technology logo for Suave Creators'],
        ];
    }
}
