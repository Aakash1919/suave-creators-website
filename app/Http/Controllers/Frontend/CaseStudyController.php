<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\CaseStudySupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CaseStudyController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.case-studies', CaseStudySupport::indexData());
    }

    public function turboTransCaseStudy(): View
    {
        return $this->view('frontend.case-studies.turbo-trans-case-study');
    }

    public function aiSalesCoachingCaseStudy(): View
    {
        return $this->view('frontend.case-studies.ai-sales-coaching-case-study');
    }

    public function outreachCaseStudy(): View
    {
        return $this->view('frontend.case-studies.outreach-case-study');
    }

    public function tasksCaseStudy(): View
    {
        return $this->view('frontend.case-studies.tasks-case-study');
    }

    public function teerrathCaseStudy(): View
    {
        return $this->draftView('frontend.case-studies.teerrath-case-study');
    }

    public function appointmentInsuranceCaseStudy(): View
    {
        return $this->view('frontend.case-studies.appointment-insurance-case-study');
    }

    public function cabviCaseStudy(): View
    {
        return $this->View('frontend.case-studies.cabvi-case-study');
    }

    public function show(string $slug): RedirectResponse
    {
        $route = CaseStudySupport::routeName($slug);
        abort_if($route === null, 404);

        return redirect()->route($route, status: 301);
    }

    protected function draftView(string $view): View
    {
        abort_unless(Auth::check(), 404);

        return $this->view($view);
    }
}
