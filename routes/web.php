<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\IndustryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ServiceController;
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
Route::get('/blogs/filter', [BlogController::class, 'filter'])->name('blogs.filter');
Route::get('/blogs/category/{slug}', [BlogController::class, 'category'])->name('blogs.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
