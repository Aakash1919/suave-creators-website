<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datatable extends Component
{
    /**
     * @param  list<array<string, mixed>>  $columns
     * @param  list<array{label: string, column: int, dir?: string}>  $sortOptions
     */
    public function __construct(
        public string $title,
        public array $columns = [],
        public ?string $description = null,
        public string $tableId = 'admin-datatable',
        public array $sortOptions = [],
        public bool $showColumnToggle = true,
    ) {}

    public function render(): View
    {
        return view('components.admin.datatable');
    }
}
