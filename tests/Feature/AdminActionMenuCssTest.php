<?php

namespace Tests\Feature;

use App\Support\Admin\DataTableActions;
use Tests\TestCase;

class AdminActionMenuCssTest extends TestCase
{
    public function test_last_table_row_action_menu_opens_upward_to_stay_visible(): void
    {
        $css = file_get_contents(public_path('css/admin.css'));

        $this->assertIsString($css);
        $this->assertStringContainsString('table.dataTable.admin-table tbody tr:last-child .admin-table__action-menu-panel', $css);
        $this->assertStringContainsString('bottom: 100%', $css);
        $this->assertStringContainsString('top: auto', $css);
        $this->assertStringContainsString('.admin-dt__scroll:has(.admin-table__action-menu[open])', $css);
    }

    public function test_action_menu_markup_uses_admin_css_classes_not_tailwind_utilities(): void
    {
        $html = DataTableActions::menu([
            ['label' => 'View', 'url' => '/admin/example'],
            ['label' => 'Delete', 'delete' => true, 'url' => '/admin/example', 'confirm' => 'Delete?'],
        ]);

        $this->assertStringContainsString('admin-table__action-menu', $html);
        $this->assertStringContainsString('admin-table__action-menu-panel', $html);
        $this->assertStringContainsString('admin-table__action-menu-item--danger', $html);
        $this->assertStringNotContainsString('cdn.tailwindcss.com', $html);
        $this->assertStringNotContainsString('top-full', $html);
    }
}
