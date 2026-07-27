<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\AboutSupport;
use Illuminate\View\View;

class AboutController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.about-us', AboutSupport::data());
    }
}
