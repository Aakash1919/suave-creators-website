<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
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
        public bool $showPeople = true,
        public bool $solo = false,
        public bool $allowHtmlTitle = true,
        public ?array $people = null,
    ) {
        if ($this->ctaHref === '') {
            $this->ctaHref = route('contact-us').'#contact-id';
        }

        if ($this->secondaryCtaHref === '' && $this->secondaryCtaLabel !== '') {
            $this->secondaryCtaHref = route('contact-us').'#contact-id';
        }

        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        $this->people ??= [
            ['src' => 'assets/team/consultation-team-member-1.png', 'alt' => 'Suave Creators consultant ready for a software discovery call', 'tone' => 'pink', 'column' => 'left'],
            ['src' => 'assets/team/consultation-team-member-2.png', 'alt' => 'Suave Creators developer available for project consultation', 'tone' => 'orange', 'column' => 'left'],
            ['src' => 'assets/team/consultation-team-leader.png', 'alt' => 'Suave Creators team leader for web development consultation', 'tone' => 'yellow', 'column' => 'center'],
            ['src' => 'assets/team/consultation-designer.png', 'alt' => 'Suave Creators UI UX designer for product consultation', 'tone' => 'blue', 'column' => 'center'],
            ['src' => 'assets/team/consultation-team-lead.png', 'alt' => 'Suave Creators project lead for CRM and software consulting', 'tone' => 'coral', 'column' => 'right'],
            ['src' => 'assets/team/consultation-team-collaborating.png', 'alt' => 'Suave Creators team collaborating on a client software project', 'tone' => 'cyan', 'column' => 'right'],
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
