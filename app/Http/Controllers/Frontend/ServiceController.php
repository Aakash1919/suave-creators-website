<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\ServiceSupport;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('frontend.services', ServiceSupport::indexData());
    }

    public function show(string $slug): View
    {
        return view('frontend.service-detail', ServiceSupport::showData($slug));
    }
}
