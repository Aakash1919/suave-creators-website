<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\CaseStudySupport;
use Illuminate\View\View;

class CaseStudyController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.case-studies', CaseStudySupport::indexData());
    }

    public function show(string $slug): View
    {
        return $this->view('frontend.single-case-study', CaseStudySupport::showData($slug));
    }
}
