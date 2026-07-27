<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AiPoweredSoftwareDevelopment2026Controller;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ChoosingTheRightTechStackController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\DigitalStrategyThatCreatesValueController;
use App\Http\Controllers\Frontend\DigitalWorkflowsTeamsUseController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\IndustryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductDataCustomerExperiencesController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\UxPrinciplesThatDriveConversionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/service/{slug}', [ServiceController::class, 'show'])->name('service.show');

Route::get('/industries', [IndustryController::class, 'index'])->name('industries');
Route::get('/industries/{slug}', [IndustryController::class, 'show'])->name('industry.show');

Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/digital-strategy-that-creates-value', [DigitalStrategyThatCreatesValueController::class, 'slug'])->name('blog.digital-strategy-that-creates-value');
Route::get('/blog/product-data-customer-experiences', [ProductDataCustomerExperiencesController::class, 'slug'])->name('blog.product-data-customer-experiences');
Route::get('/blog/digital-workflows-teams-use', [DigitalWorkflowsTeamsUseController::class, 'slug'])->name('blog.digital-workflows-teams-use');
Route::get('/blog/ai-powered-software-development-2026', [AiPoweredSoftwareDevelopment2026Controller::class, 'slug'])->name('blog.ai-powered-software-development-2026');
Route::get('/blog/choosing-the-right-tech-stack', [ChoosingTheRightTechStackController::class, 'slug'])->name('blog.choosing-the-right-tech-stack');
Route::get('/blog/ux-principles-that-drive-conversions', [UxPrinciplesThatDriveConversionsController::class, 'slug'])->name('blog.ux-principles-that-drive-conversions');
