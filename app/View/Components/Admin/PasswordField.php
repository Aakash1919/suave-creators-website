<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordField extends Component
{
    public string $id;

    /**
     * Password input with show/hide eye toggle.
     */
    public function __construct(
        public string $name = 'password',
        public string $label = 'Password',
        public string $value = '',
        public string $placeholder = '••••••••',
        public string $autocomplete = 'current-password',
        public bool $required = false,
        public bool $showLabel = true,
        public string $inputClass = 'admin-input',
        ?string $id = null,
    ) {
        $this->id = $id ?? $name;
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.password-field');
    }
}
