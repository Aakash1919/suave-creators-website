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
        public string $eyebrow = 'GET IN TOUCH',
        public string $title = 'Have a Complex Software Architecture or Custom CRM Requirement?',
        public string $description = 'Discuss your product roadmap, API integrations, or legacy migration plans directly with a solution architect.',
        public string $titleId = 'connect-cta-title',
        public string $primaryLabel = 'Book a Discovery Session ',
        public string $primaryHref = '',
        public string $secondaryLabel = 'Discuss Your Technical Roadmap',
        public string $secondaryHref = '',
        public string $phoneVideo = 'assets/hero/mobile-app-phone-demo.mp4',
        public string $phonePoster = 'assets/hero/mobile-app-phone-demo-poster.webp',
        public string $phoneAlt = 'Mobile app demo for a custom CRM and software product',
        public bool $showPhone = true,
        public string $sectionClass = 'full-bleed smart-together-cta py-6',
    ) {
        if ($this->primaryHref === '') {
            $this->primaryHref = ContactSupport::demoHref();
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
