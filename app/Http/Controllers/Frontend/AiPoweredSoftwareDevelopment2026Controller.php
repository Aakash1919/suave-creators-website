<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\BlogSupport;
use Illuminate\View\View;

class AiPoweredSoftwareDevelopment2026Controller extends Controller
{
    public function slug(): View
    {
        return view('frontend.single-blog', BlogSupport::showData('ai-powered-software-development-2026'));
    }
}
