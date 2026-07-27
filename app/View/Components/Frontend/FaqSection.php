<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class FaqSection extends Component
{
    use NormalizesAssetPaths;

    public string $resolvedMediaType;

    /**
     * @param  array<int, array{question?: string, answer?: string, 0?: string, 1?: string}>  $qa
     */
    public function __construct(
        public array $qa = [],
        public ?string $media = 'assets/media/faq-team-collaboration.gif',
        public ?string $mediaType = null,
        public string $mediaAlt = 'Business team collaborating on a custom software project with Suave Creators',
        public string $eyebrow = 'Have questions about our Web Services?',
        public string $title = 'Frequently Ask Question',
        public string $description = 'Here are the most asked questions based on feedback from our users.',
        public string $headingId = 'faq-heading',
        public string $ctaHref = '',
        public string $ctaLabel = 'Start your Project',
        public bool $showCta = true,
    ) {
        $this->media = filled($this->media) ? $this->normalizeAssetPath($this->media) : null;

        if ($this->ctaHref === '') {
            $this->ctaHref = route('contact-us').'#contact-id';
        }

        $this->resolvedMediaType = $this->mediaType
            ?? $this->detectMediaType($this->media);

        $this->qa = array_values(array_map(function (array $item, int $index): array {
            return [
                'question' => (string) ($item['question'] ?? $item[0] ?? ''),
                'answer' => (string) ($item['answer'] ?? $item[1] ?? ''),
                'number' => $index + 1,
            ];
        }, $this->qa, array_keys($this->qa)));
    }

    protected function detectMediaType(?string $media): string
    {
        if ($media === null || $media === '') {
            return 'image';
        }

        $path = (string) str($media)->before('?')->before('#');
        $extension = Str::lower((string) str($path)->afterLast('.'));

        return in_array($extension, ['mp4', 'webm', 'ogg', 'ogv', 'mov'], true)
            ? 'video'
            : 'image';
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.faq-section');
    }
}
