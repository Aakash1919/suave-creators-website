<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\IndustryDetailSupport;
use App\Support\Frontend\IndustrySupport;
use Illuminate\View\View;

class IndustryController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.industries', IndustrySupport::data());
    }

    public function show(string $slug): View
    {
        return $this->view('frontend.industry-detail', IndustryDetailSupport::showData($slug));
    }
}
