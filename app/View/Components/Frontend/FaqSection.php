<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FaqSection extends Component
{
    public string $resolvedMediaType;

    /**
     * @param  array<int, array{question?: string, answer?: string, 0?: string, 1?: string}>  $qa
     */
    public function __construct(
        public array $qa = [],
        public ?string $media = '/images/faq-gif.gif',
        public ?string $mediaType = null,
        public string $mediaAlt = 'Business team collaborating around a table',
        public string $eyebrow = 'Have questions about our Web Services?',
        public string $title = 'Frequently Ask Question',
        public string $description = 'Here are the most asked questions based on feedback from our users.',
        public string $headingId = 'faq-heading',
        public string $ctaHref = '/contact-us/#contact-id',
        public string $ctaLabel = 'Start your Project',
        public bool $showCta = true,
    ) {
        $this->resolvedMediaType = $this->mediaType
            ?? $this->detectMediaType($this->media);

        $this->qa = array_values(array_map(function (array $item): array {
            return [
                'question' => (string) ($item['question'] ?? $item[0] ?? ''),
                'answer' => (string) ($item['answer'] ?? $item[1] ?? ''),
            ];
        }, $this->qa));
    }

    protected function detectMediaType(?string $media): string
    {
        if ($media === null || $media === '') {
            return 'image';
        }

        $extension = strtolower(pathinfo(parse_url($media, PHP_URL_PATH) ?: $media, PATHINFO_EXTENSION));

        return in_array($extension, ['mp4', 'webm', 'ogg', 'ogv', 'mov'], true)
            ? 'video'
            : 'image';
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.faq-section');
    }
}
