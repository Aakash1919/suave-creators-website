<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\BlogSupport;
use Illuminate\View\View;

class DigitalWorkflowsTeamsUseController extends Controller
{
    public function slug(): View
    {
        return view('frontend.single-blog', BlogSupport::showData('digital-workflows-teams-use'));
    }
}
