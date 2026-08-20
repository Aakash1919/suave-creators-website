<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CaseStudyController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\IndustryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\SuaveAgentController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap');
Route::get('/llm.txt', [SitemapController::class, 'llmTxt'])->name('llm.txt');
Route::get('/llms.txt', [SitemapController::class, 'llmTxt'])->name('llms.txt');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact-us.store');
Route::post('/contact-us/draft', [ContactController::class, 'draft'])
    ->middleware('throttle:30,1')
    ->name('contact-us.draft');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/service/{slug}', fn (string $slug) => redirect()->route('service.show', ['slug' => $slug], 301));
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('service.show');

Route::redirect('/industry', '/industries', 301);
Route::get('/main/public/{path}', fn (string $path) => redirect('/'.ltrim($path, '/'), 301))
    ->where('path', '.*');
Route::get('/industries', [IndustryController::class, 'index'])->name('industries');
Route::get('/industries/{slug}', [IndustryController::class, 'show'])->name('industry.show');

Route::get('/ai-powered-outreach-crm', [ProductController::class, 'index'])->name('product');

Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('case-studies');
Route::get('/turbo-trans-case-study', [CaseStudyController::class, 'turboTransCaseStudy'])->name('turbo-trans-case-study');
Route::get('/ai-sales-coaching-case-study', [CaseStudyController::class, 'aiSalesCoachingCaseStudy'])->name('ai-sales-coaching-case-study');
Route::get('/outreach-case-study', [CaseStudyController::class, 'outreachCaseStudy'])->name('outreach-case-study');
Route::get('/tasks-case-study', [CaseStudyController::class, 'tasksCaseStudy'])->name('tasks-case-study');
Route::get('/teerrath-case-study', [CaseStudyController::class, 'teerrathCaseStudy'])->name('teerrath-case-study');
Route::get('/appointment-insurance-case-study', [CaseStudyController::class, 'appointmentInsuranceCaseStudy'])->name('appointment-insurance-case-study');
Route::get('/cabvi-case-study', [CaseStudyController::class, 'cabviCaseStudy'])->name('cabvi-case-study');
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show'])->name('case-study.show');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blogs/filter', [BlogController::class, 'filter'])->name('blogs.filter');
Route::get('/blogs/category/{slug}', [BlogController::class, 'category'])->name('blogs.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::prefix('suave-agent')->name('suave-agent.')->group(function () {
    Route::post('/start', [SuaveAgentController::class, 'start'])
        ->middleware('throttle:10,1')
        ->name('start');
    Route::post('/chat', [SuaveAgentController::class, 'chat'])
        ->middleware('throttle:30,1')
        ->name('chat');
    Route::get('/history', [SuaveAgentController::class, 'history'])
        ->middleware('throttle:30,1')
        ->name('history');
});
