<?php

namespace App\View\Components\Frontend\Modal;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContactModal extends Component
{
    /**
     * @var list<array{value: string, label: string, icon: string, color: string}>
     */
    public array $servicesList;

    /**
     * Site-wide consultation / contact modal.
     *
     * @param  list<array{value: string, label: string, icon: string, color: string}>|null  $services
     */
    public function __construct(
        public string $id = 'contact-modal',
        ?array $services = null,
    ) {
        $this->servicesList = $services ?? ContactSupport::formServiceOptions();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.modal.contact-modal');
    }
}
