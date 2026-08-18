<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\CaseStudySupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CaseStudyController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.case-studies', CaseStudySupport::indexData());
    }

    public function aiSalesCoachingCaseStudy(): View
    {
        return $this->staticPage('ai-sales-coaching-platform-case-study', 'frontend.case-studies.ai-sales-coaching-case-study');
    }

    public function outreachCaseStudy(): View
    {
        return $this->staticPage('suave-crm-outreach-case-study', 'frontend.case-studies.outreach-case-study');
    }

    public function tasksCaseStudy(): View
    {
        return $this->staticPage('suave-crm-tasks-case-study', 'frontend.case-studies.tasks-case-study');
    }

    public function teerrathCaseStudy(): View
    {
        return $this->staticPage('teerrath-spiritual-commerce', 'frontend.case-studies.teerrath-case-study');
    }

    public function appointmentInsuranceCaseStudy(): View
    {
        return $this->staticPage('appointment-insurance-platform-case-study', 'frontend.case-studies.appointment-insurance-case-study');
    }

    public function cabviCaseStudy(): View
    {
        return $this->staticPage('cabvi-product-matching', 'frontend.case-studies.cabvi-case-study');
    }

    public function show(string $slug): RedirectResponse
    {
        $route = CaseStudySupport::routeName($slug);
        abort_if($route === null, 404);

        return redirect()->route($route, status: 301);
    }

    protected function staticPage(string $slug, string $view): View
    {
        return $this->view($view, CaseStudySupport::staticData($slug));
    }
}
