<?php

namespace App\Http\Controllers\Frontend;

use App\Support\Frontend\EnterpriseAiErpSupport;
use Illuminate\View\View;

class EnterpriseAiErpController extends FrontendController
{
    public function index(): View
    {
        return $this->view('frontend.enterprise-ai-erp', EnterpriseAiErpSupport::data());
    }
}
