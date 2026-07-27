<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Frontend\ProductSupport;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('frontend.product', ProductSupport::data());
    }
}
