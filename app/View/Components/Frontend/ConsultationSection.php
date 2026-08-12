<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConsultationSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{src: string, alt: string, tone: string, column: string}>|null  $people
     */
    public function __construct(
        public string $title = "Let's Build Your Next Digital<br class=\"hidden sm:block\"> Solution with us!",
        public string $description = 'Book a consultation for your next digital project. Suave Creators delivers quality work, stays ahead of trends, and is here to help.',
        public string $ctaLabel = 'Book a Free Consultation',
        public string $ctaHref = '',
        public string $secondaryCtaLabel = '',
        public string $secondaryCtaHref = '',
        public string $backgroundImage = 'assets/background/consultation-section-bg.png',
        public string $eyebrow = '',
        public string $cardPosition = 'top',
        public bool $showPeople = true,
        public bool $solo = false,
        public bool $allowHtmlTitle = true,
        public bool $hideBgBelowDesktop = false,
        public ?array $people = null,
    ) {
        if ($this->ctaHref === '') {
            $this->ctaHref = ContactSupport::demoHref();
        }

        if ($this->secondaryCtaHref === '' && $this->secondaryCtaLabel !== '') {
            $this->secondaryCtaHref = ContactSupport::demoHref();
        }

        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        $this->people ??= [
            ['src' => 'assets/team/woman-short-bob-white-sweater-portrait.webp', 'alt' => 'Suave Creators software developer ready for a project consultation', 'tone' => 'pink', 'column' => 'left'],
            ['src' => 'assets/team/man-beard-blue-sweater-portrait.webp', 'alt' => 'Suave Creators product specialist available for consultation', 'tone' => 'orange', 'column' => 'left'],
            ['src' => 'assets/team/bearded-man-red-vneck-portrait.webp', 'alt' => 'Suave Creators technology leader for web development consultation', 'tone' => 'yellow', 'column' => 'center'],
            ['src' => 'assets/team/young-man-teal-crewneck-portrait.webp', 'alt' => 'Suave Creators project lead for CRM and software consulting', 'tone' => 'blue', 'column' => 'center'],
            ['src' => 'assets/team/woman-crossed-arms-olive-turtleneck-portrait.webp', 'alt' => 'Suave Creators UI UX designer for product consultation', 'tone' => 'coral', 'column' => 'right'],
            ['src' => 'assets/team/bearded-man-navy-button-down-portrait.webp', 'alt' => 'Suave Creators software consultant ready for a digital project discussion', 'tone' => 'cyan', 'column' => 'right'],
        ];

        $this->people = array_values(array_map(function (array $person): array {
            return [
                'src' => $this->normalizeAssetPath((string) ($person['src'] ?? '')),
                'alt' => (string) ($person['alt'] ?? 'Suave Creators team member for software consultation'),
                'tone' => (string) ($person['tone'] ?? 'blue'),
                'column' => (string) ($person['column'] ?? 'center'),
            ];
        }, $this->people));
    }

    /**
     * @return array<string, array<int, array{src: string, alt: string, tone: string, column: string}>>
     */
    public function peopleByColumn(): array
    {
        $columns = ['left' => [], 'center' => [], 'right' => []];

        foreach ($this->people as $person) {
            $column = $person['column'] ?? 'center';
            if (! isset($columns[$column])) {
                $column = 'center';
            }
            $columns[$column][] = $person;
        }

        return $columns;
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.consultation-section');
    }
}
