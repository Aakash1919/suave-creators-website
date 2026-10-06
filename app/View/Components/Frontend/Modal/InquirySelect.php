<?php

namespace App\View\Components\Frontend\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InquirySelect extends Component
{
    /**
     * Custom listbox select used in inquiry modals (contact-modal style).
     *
     * @param  array<int|string, string|array{value?: string, label?: string, icon?: string, color?: string}>  $options
     */
    public function __construct(
        public string $name,
        public array $options = [],
        public string $placeholder = 'Select an option',
        public ?string $labelId = null,
        public bool $required = true,
        public string $defaultIcon = 'fa-solid fa-shapes',
        public string $defaultColor = '#64748B',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.modal.inquiry-select');
    }
}
