<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('permission:seo.audit')->group(function () {
        Route::post('/seo-audit-report', [DashboardController::class, 'generateSeoReport'])
            ->name('seo-audit-report.generate');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::middleware('permission:blogs.view')->group(function () {
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    });

    Route::middleware('permission:blogs.create')->group(function () {
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    });

    Route::middleware('permission:blogs.update')->group(function () {
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::post('/blogs/{blog}/generate-seo', [BlogController::class, 'generateSeoMeta'])
            ->name('blogs.generate-seo');
    });

    Route::middleware('permission:blogs.delete')->group(function () {
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    });

    Route::middleware('permission:case-studies.view')->group(function () {
        Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('case-studies.index');
    });

    Route::middleware('permission:case-studies.create')->group(function () {
        Route::get('/case-studies/create', [CaseStudyController::class, 'create'])->name('case-studies.create');
        Route::post('/case-studies', [CaseStudyController::class, 'store'])->name('case-studies.store');
    });

    Route::middleware('permission:case-studies.update')->group(function () {
        Route::get('/case-studies/{caseStudy}/edit', [CaseStudyController::class, 'edit'])->name('case-studies.edit');
        Route::put('/case-studies/{caseStudy}', [CaseStudyController::class, 'update'])->name('case-studies.update');
    });

    Route::middleware('permission:case-studies.delete')->group(function () {
        Route::delete('/case-studies/{caseStudy}', [CaseStudyController::class, 'destroy'])->name('case-studies.destroy');
    });

    Route::middleware('permission:conversations.view')->group(function () {
        Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
        Route::get('/conversations/{lead}', [ConversationController::class, 'show'])->name('conversations.show');
    });

    Route::middleware('permission:contacts.view')->group(function () {
        Route::get('/contacts', [ContactRequestController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactRequestController::class, 'show'])->name('contacts.show');
        Route::patch('/contacts/{contact}/archive', [ContactRequestController::class, 'archive'])->name('contacts.archive');
    });

    Route::middleware('permission:testimonials.view')->group(function () {
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    });

    Route::middleware('permission:testimonials.manage')->group(function () {
        Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::get('/testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    });

    Route::middleware('permission:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });

    Route::middleware('permission:users.manage')->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    Route::middleware('permission:roles.view')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    });

    Route::middleware('permission:roles.manage')->group(function () {
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });
});
