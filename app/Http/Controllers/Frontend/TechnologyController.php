<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\TechnologySupport;
use Illuminate\View\View;

class TechnologyController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.technologies', TechnologySupport::data());
    }
}
