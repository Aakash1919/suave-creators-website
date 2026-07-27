<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\BlogSupport;
use Illuminate\View\View;

class UxPrinciplesThatDriveConversionsController extends Controller
{
    public function slug(): View
    {
        return view('frontend.single-blog', BlogSupport::showData('ux-principles-that-drive-conversions'));
    }
}
