<?php

namespace App\View\Components\Frontend\Modal;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectEstimateModal extends Component
{
    /**
     * @var list<array{value: string, label: string, icon: string, color: string}>
     */
    public array $serviceOptions;

    /**
     * @var list<array{value: string, label: string, icon: string, color: string}>
     */
    public array $budgetOptions;

    /**
     * Reusable “Get a Project Estimate” inquiry dialog.
     *
     * @param  list<array{value: string, label: string, icon: string, color: string}>|null  $services
     * @param  list<array{value: string, label: string, icon: string, color: string}>|null  $budgets
     */
    public function __construct(
        public string $dialogId = 'project-estimate-dialog',
        public string $formId = 'project-estimate-form',
        ?array $services = null,
        ?array $budgets = null,
    ) {
        $this->serviceOptions = $services ?? ContactSupport::projectEstimateServiceOptions();
        $this->budgetOptions = $budgets ?? ContactSupport::projectEstimateBudgetOptions();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.modal.project-estimate-modal');
    }
}
