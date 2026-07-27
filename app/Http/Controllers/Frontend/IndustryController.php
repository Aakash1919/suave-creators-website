<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\IndustryDetailSupport;
use App\Support\Frontend\IndustrySupport;
use Illuminate\View\View;

class IndustryController extends Controller
{
    public function index(): View
    {
        return view('frontend.industries', IndustrySupport::data());
    }

    public function show(string $slug): View
    {
        return view('frontend.industry-detail', IndustryDetailSupport::showData($slug));
    }
}
