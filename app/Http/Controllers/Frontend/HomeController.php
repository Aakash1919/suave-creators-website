<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\HomeSupport;
use Illuminate\View\View;

class HomeController extends FrontendController
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        return $this->view('frontend.home', HomeSupport::data());
    }
}
