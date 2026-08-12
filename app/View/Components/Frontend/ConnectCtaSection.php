<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConnectCtaSection extends Component
{
    use NormalizesAssetPaths;

    public function __construct(
        public string $eyebrow = 'Connect with us',
        public string $title = 'Let’s Build Something Smart Together',
        public string $description = 'Ready to transform your ideas into reality with Suave Creators?',
        public string $titleId = 'connect-cta-title',
        public string $primaryLabel = 'Get Started',
        public string $primaryHref = '',
        public string $secondaryLabel = 'Discuss your Vision',
        public string $secondaryHref = '',
        public string $phoneVideo = 'assets/hero/mobile-app-phone-demo.mp4',
        public string $phonePoster = 'assets/hero/mobile-app-phone-demo-poster.webp',
        public string $phoneAlt = 'Mobile app demo for a custom CRM and software product',
        public bool $showPhone = true,
        public string $sectionClass = 'full-bleed smart-together-cta py-6',
    ) {
        if ($this->primaryHref === '') {
            $this->primaryHref = route('contact-us').'#contact-id';
        }

        if ($this->secondaryHref === '') {
            $this->secondaryHref = ContactSupport::demoHref();
        }

        $this->phoneVideo = $this->normalizeAssetPath($this->phoneVideo);
        $this->phonePoster = $this->normalizeAssetPath($this->phonePoster);
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.connect-cta-section');
    }
}
