<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\CustomCrmBuilderSupport;
use Illuminate\View\View;

class CustomCrmBuilderController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.custom-crm-builder', CustomCrmBuilderSupport::data());
    }
}
