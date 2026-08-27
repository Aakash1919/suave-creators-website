<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminBlogBlocksToolbarTest extends TestCase
{
    public function test_blog_form_exposes_labeled_layout_insert_buttons(): void
    {
        $form = file_get_contents(resource_path('views/admin/blogs/form.blade.php'));

        $this->assertStringContainsString('data-blog-editor="undo"', $form);
        $this->assertStringContainsString('data-blog-editor="redo"', $form);
        $this->assertStringContainsString('data-blog-editor="removeblock"', $form);
        $this->assertStringNotContainsString('data-blog-chart-editor', $form);

        foreach ([
            'inserttakeaways',
            'insertresults',
            'insertchecklist',
            'insertstats',
            'insertchart',
            'insertinsight',
            'insertblogtable',
        ] as $command) {
            $this->assertStringContainsString('data-blog-block="'.$command.'"', $form);
        }
    }

    public function test_blog_block_plugin_inserts_public_page_markup(): void
    {
        $plugin = file_get_contents(public_path('js/admin/blog-blocks-plugin.js'));

        $this->assertIsString($plugin);
        $this->assertStringContainsString('removeNearest', $plugin);
        $this->assertStringContainsString('window.SuaveBlogBlocks', $plugin);
        $this->assertStringContainsString("class=\"blog-takeaways\"", $plugin);
        $this->assertStringContainsString("class=\"blog-results\"", $plugin);
        $this->assertStringContainsString("class=\"blog-checklist\"", $plugin);
        $this->assertStringContainsString("class=\"blog-stats\"", $plugin);
        $this->assertStringContainsString("class=\"blog-chart\"", $plugin);
        $this->assertStringContainsString("class=\"blog-chart__value\"", $plugin);
        $this->assertStringContainsString("class=\"blog-insight\"", $plugin);
        $this->assertStringContainsString("class=\"blog-table-wrap\"", $plugin);
    }

    public function test_blog_toolbar_preset_includes_layout_commands(): void
    {
        $scripts = file_get_contents(resource_path('views/layouts/admin/partials/richtexteditor-scripts.blade.php'));

        $this->assertIsString($scripts);
        $this->assertStringContainsString('blog-blocks-plugin.js', $scripts);
        $this->assertStringContainsString('{undo,redo}', $scripts);
        $this->assertStringContainsString('{inserttakeaways,insertresults,insertchecklist,insertstats,insertchart,insertinsight,insertblogtable}', $scripts);
    }
}
