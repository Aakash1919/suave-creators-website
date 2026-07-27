<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;

class PageController extends FrontendController
{
    public function privacyPolicy(): View
    {
        return $this->view('frontend.privacy-policy');
    }

    public function termsAndConditions(): View
    {
        return $this->view('frontend.terms-and-conditions');
    }
}
