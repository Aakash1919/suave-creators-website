<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\BlogSupport;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display the blogs listing page.
     */
    public function index(): View
    {
        return view('frontend.blogs', BlogSupport::indexData());
    }
}
