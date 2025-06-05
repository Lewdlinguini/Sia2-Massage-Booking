<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\EmailCodeVerificationController;
use App\Http\Controllers\Auth\TwoFactorLoginController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;

// Redirect root URL to login
Route::get('/', fn () => redirect('/login'));

// Public pages
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Guest-only routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/2fa', [TwoFactorLoginController::class, 'show2faForm'])->name('2fa.form');
    Route::post('/2fa', [TwoFactorLoginController::class, 'verify2faCode'])->name('2fa.verify');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated users — email code verification ONLY
Route::middleware('auth')->group(function () {
    Route::get('/email/verify-code', [EmailCodeVerificationController::class, 'showForm'])->name('verification.code.form');
    Route::post('/email/verify-code', [EmailCodeVerificationController::class, 'verify'])->name('verification.code.verify');
    Route::post('/email/resend-code', [EmailCodeVerificationController::class, 'resend'])->name('verification.code.resend');
});

// Verified users — full access
Route::middleware('auth')->group(function () {

    // Use HomeController@index instead of closure
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/rate', [App\Http\Controllers\RatingController::class, 'store'])->name('rate.service');

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity.log');

    // Services routes
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}/book', [ServiceController::class, 'book'])->name('services.book');

    Route::middleware('check.role:Admin,Masseuse')->group(function () {
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    });

    Route::get('/profile/security', [SecurityController::class, 'show2faForm'])->name('profile.security');
    Route::put('/profile/security/password', [SecurityController::class, 'updatePassword'])->name('profile.password.update');

    Route::resource('services', ServiceController::class)->except(['show']);

    // Booking routes
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Masseuse/Admin-only
    Route::middleware('check.role:Admin,Masseuse')->group(function () {
        Route::get('/masseuse-bookings', [BookingController::class, 'masseuseBookings'])->name('bookings.masseuse');
        Route::get('/services/bookings/{booking}/location', [BookingController::class, 'showLocation'])->name('services.location');
    });

    // 2FA enable/disable routes - only for authenticated and verified users
    Route::middleware('verified')->group(function () {
        Route::post('/profile/2fa/enable', [SecurityController::class, 'enable2FA'])->name('profile.2fa.enable');
        Route::post('/profile/2fa/disable', [SecurityController::class, 'disable2FA'])->name('profile.2fa.disable');
    });

    Route::post('/notifications/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    })->name('notifications.markAsRead');

    
    // Admin routes — only for Admin role
Route::middleware(['auth', 'check.role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User management routes
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/security', [SecurityController::class, 'show2faForm'])->name('profile.security');
});
});