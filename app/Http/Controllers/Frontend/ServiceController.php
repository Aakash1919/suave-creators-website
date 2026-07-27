<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\ServiceSupport;
use Illuminate\View\View;

class ServiceController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.services', ServiceSupport::indexData());
    }

    public function show(string $slug): View
    {
        return $this->view('frontend.service-detail', ServiceSupport::showData($slug));
    }
}
