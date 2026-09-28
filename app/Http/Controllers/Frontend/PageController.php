<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;

class PageController extends FrontendController
{
    public function privacyPolicy(): View
    {
        return $this->view('frontend.privacy-policy');
    }

    public function termsAndConditions(): View
    {
        return $this->view('frontend.terms-and-conditions');
    }

    public function thankYou(): View
    {
        return $this->view('frontend.thank-you', [
            'seo' => [
                'title' => 'Thank You | Suave Creators',
                'description' => 'Thank you for contacting Suave Creators. We have received your inquiry and our technical experts will get back to you within 24 hours.',
                'robots' => 'noindex, follow',
            ],
            'withSeo' => true,
        ]);
    }
}
