<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function privacyPolicy(): View
    {
        return view('frontend.privacy-policy');
    }

    public function termsAndConditions(): View
    {
        return view('frontend.terms-and-conditions');
    }
}
