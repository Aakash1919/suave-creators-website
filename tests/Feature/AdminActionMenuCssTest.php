<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminActionMenuCssTest extends TestCase
{
    public function test_last_table_row_action_menu_opens_upward_to_stay_visible(): void
    {
        $css = file_get_contents(public_path('css/admin.css'));

        $this->assertIsString($css);
        $this->assertStringContainsString('table.dataTable.admin-table tbody tr:last-child .admin-table__actions details > div', $css);
        $this->assertStringContainsString('bottom: 100%', $css);
        $this->assertStringContainsString('top: auto', $css);
    }
}
