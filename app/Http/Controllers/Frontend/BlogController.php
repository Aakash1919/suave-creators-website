<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\BlogSupport;
use Illuminate\View\View;

class BlogController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.blogs', BlogSupport::indexData());
    }

    public function show(string $slug): View
    {
        return $this->view('frontend.single-blog', BlogSupport::showData($slug));
    }
}
