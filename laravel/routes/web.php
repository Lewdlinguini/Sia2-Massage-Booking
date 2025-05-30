<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Redirect root URL directly to the login URL
Route::get('/', fn () => redirect('/login'));

// ✅ Public static pages
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ✅ Guest-only routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// ✅ Authenticated-only routes
Route::middleware('auth')->group(function () {
    Route::get('/home', fn () => view('home'))->name('home');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity.log');

    // ✅ Services Routes
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    
    // ✅ Booking a service (this must be BEFORE resource routes)
    Route::get('/services/{service}/book', [ServiceController::class, 'book'])->name('services.book');

    // ✅ Admin and Masseuse-only service creation
    Route::middleware('check.role:Admin,Masseuse')->group(function () {
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    });

    // ✅ Resource routes (excluding 'show' to avoid conflict with /{service}/book)
    Route::resource('services', ServiceController::class)->except(['show']);

    // ✅ Booking-related routes
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // ✅ Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('check.role:Admin,Masseuse')->group(function () {
    Route::get('/masseuse-bookings', [BookingController::class, 'masseuseBookings'])->name('bookings.masseuse');
    Route::get('/services/bookings/{booking}/location', [BookingController::class, 'showLocation'])->name('services.location');
    Route::post('/notifications/mark-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'success']);
})->middleware('auth')->name('notifications.markAsRead');

});
    Route::middleware(['auth', 'check.role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('users', [UserManagementController::class, 'store'])->name('users.store');
});
});