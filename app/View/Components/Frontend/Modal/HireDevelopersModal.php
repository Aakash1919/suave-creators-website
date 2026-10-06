<?php

namespace App\View\Components\Frontend\Modal;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HireDevelopersModal extends Component
{
    /**
     * @var list<array{value: string, label: string, icon: string, color: string}>
     */
    public array $expertiseOptions;

    /**
     * @var list<array{value: string, label: string, icon: string, color: string}>
     */
    public array $supportOptions;

    /**
     * @var list<array{value: string, label: string, icon: string, color: string}>
     */
    public array $startOptions;

    /**
     * Reusable “Hire the Right Developers” inquiry dialog.
     *
     * @param  list<array{value: string, label: string, icon: string, color: string}>|null  $expertiseOptions
     * @param  list<array{value: string, label: string, icon: string, color: string}>|null  $supportOptions
     * @param  list<array{value: string, label: string, icon: string, color: string}>|null  $startOptions
     */
    public function __construct(
        public string $dialogId = 'hire-developers-dialog',
        public string $formId = 'hire-developers-form',
        ?array $expertiseOptions = null,
        ?array $supportOptions = null,
        ?array $startOptions = null,
    ) {
        $this->expertiseOptions = $expertiseOptions ?? ContactSupport::hireExpertiseSelectOptions();
        $this->supportOptions = $supportOptions ?? ContactSupport::hireSupportSelectOptions();
        $this->startOptions = $startOptions ?? ContactSupport::hireStartSelectOptions();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.modal.hire-developers-modal');
    }
}
