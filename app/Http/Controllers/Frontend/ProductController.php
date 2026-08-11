<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\ProductSupport;
use Illuminate\View\View;

class ProductController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.product', array_merge(
            ProductSupport::data(),
            ProductSupport::seoStructuredData(),
        ));
    }
}
