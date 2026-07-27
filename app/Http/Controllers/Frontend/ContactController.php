<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\ContactSupport;
use Illuminate\View\View;

class ContactController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.contact-us', ContactSupport::data());
    }
}
