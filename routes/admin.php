<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
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
    });

    Route::middleware('permission:blogs.delete')->group(function () {
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
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

    Route::middleware('permission:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });

    Route::middleware('permission:users.manage')->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });
});
