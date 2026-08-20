<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationCtaLabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_primary_project_ctas_use_free_consultation_label(): void
    {
        foreach (['/', '/industries', '/services/enterprise-software-solutions'] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertSee('Get Free Consultation', false);
            $response->assertDontSee('Start your Project', false);
        }
    }
}
