<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\BlogSupport;
use Illuminate\View\View;

class ChoosingTheRightTechStackController extends Controller
{
    public function slug(): View
    {
        return view('frontend.single-blog', BlogSupport::showData('choosing-the-right-tech-stack'));
    }
}
