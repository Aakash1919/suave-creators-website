<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PhoneField extends Component
{
    public string $geoCountryUrl;

    public string $initialCountry;

    /**
     * Reusable international phone input (intl-tel-input) with IP country detection.
     */
    public function __construct(
        public string $name = 'phone',
        public string $id = 'contact-phone',
        public string $label = 'Phone',
        public string $value = '',
        public string $placeholder = '98765 43210',
        public string $autocomplete = 'tel-national',
        public bool $showLabel = true,
        ?string $geoCountryUrl = null,
        ?string $initialCountry = null,
    ) {
        $this->geoCountryUrl = $geoCountryUrl ?? route('geo.country');
        $detected = $initialCountry ?? ContactSupport::visitorCountry();
        $this->initialCountry = is_string($detected) ? strtolower($detected) : '';
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.phone-field');
    }
}
