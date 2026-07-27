<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThreeCardSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{0?: string, 1?: string, 2?: string, 3?: string, 4?: string, icon?: string, category?: string, title?: string, description?: string, tone?: string}>  $items
     */
    public function __construct(
        public string $eyebrow = 'Web Development Services',
        public string $title = 'From Concept to Code, We Build Digital Excellence.',
        public string $subtitle = 'We build cost-effective and custom solutions which is tailored to your business needs.',
        public array $items = [],
        public string $headingId = 'three-card-title',
        public string $backgroundImage = 'assets/background/web-services-section-bg.png',
        public string $ctaHref = '',
        public string $ctaLabel = 'See All Services',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        if ($this->ctaHref === '') {
            $this->ctaHref = route('services');
        }

        if ($this->items === []) {
            $this->items = [
                ['assets/icons/web-development-icon.svg', '01 - Development', 'Web Development Services', 'Explore our top-notch web development services to get the best possible digital solution to enhance user interaction and scale seamlessly as your needs grow.', 'blue', 'Custom web development services icon for scalable business websites'],
                ['assets/icons/enterprise-software-icon.svg', '02 - Enterprise Software', 'Enterprise Software Solutions', 'We offer the best and industry-specific Enterprise Software Solutions for organisations to manage their work more conveniently. Get a secure and scalable solution with us.', 'orange', 'Enterprise software solutions icon for secure business platforms'],
                ['assets/icons/ui-ux-design-icon.svg', '03 - Design Service', 'UI/UX Design Services', 'UI/UX Designs help you to stand out in the competition. We are experts in front-end design, optimising custom code to deliver the best UI/UX design services.', 'cyan', 'UI UX design services icon for user-focused product interfaces'],
                ['assets/icons/custom-crm-icon.svg', '04 - Custom CRM', 'Custom CRM Development', 'Suave Creators develops custom-tailored CRM Solutions, implementing application development software features and functionalities that drive businesses forward.', 'mint', 'Custom CRM development icon for sales and customer management software'],
                ['assets/icons/ecommerce-development-icon.svg', '05 - E-commerce Development', 'E-commerce Development', 'Choosing e-commerce development with us is the best option for you. Try our best development services and get a reliable solution for your digital business needs.', 'rose', 'Ecommerce development icon for online store and shopping platforms'],
                ['assets/icons/ai-solutions-icon.svg', '06 - AI Solutions', 'AI Solutions', 'With this fast technology world, everyone needs an AI solution. We embed an AI solution with all of our software solutions. AI helps businesses to make it more secure, advanced, and productive.', 'amber', 'AI solutions icon for intelligent software and automation features'],
            ];
        }

        $this->items = array_values(array_map(function (array $item): array {
            $title = (string) ($item['title'] ?? $item[2] ?? '');

            return [
                'icon' => $this->normalizeImageAssetPath((string) ($item['icon'] ?? $item[0] ?? '')),
                'category' => (string) ($item['category'] ?? $item[1] ?? ''),
                'title' => $title,
                'description' => (string) ($item['description'] ?? $item[3] ?? ''),
                'tone' => (string) ($item['tone'] ?? $item[4] ?? 'blue'),
                'iconAlt' => (string) ($item['iconAlt'] ?? $item[5] ?? ($title !== '' ? $title.' service icon' : 'Suave Creators service icon')),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.three-card-section');
    }
}
