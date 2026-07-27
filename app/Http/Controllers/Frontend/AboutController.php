<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\AboutSupport;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('frontend.about-us', AboutSupport::data());
    }
}
