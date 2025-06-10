<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BicycleController;
use App\Http\Controllers\Admin\BookingReportController;
use App\Http\Controllers\Student\BookingController;  // Add this line
use App\Http\Controllers\Student\StripeController;  // Add this line

Route::middleware(['web'])->group(function () {
    // Authentication Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        
        // Password Reset Routes
        Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])
            ->name('password.request');
        Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])
            ->name('password.email');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role === 'admin') {
                return view('admin.dashboard');
            }
            return view('welcome');
        })->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Admin routes
        Route::middleware('role:admin')->group(function () {
            Route::resource('admin/users', UserController::class)->names('admin.users');
            Route::resource('admin/bicycles', BicycleController::class)->names('admin.bicycles');
            
            // Booking Reports
            Route::get('admin/reports/bookings', [BookingReportController::class, 'index'])->name('admin.reports.bookings');
            Route::get('admin/reports/bookings/print', [BookingReportController::class, 'print'])->name('admin.reports.bookings.print');
        });

        // Student routes
        Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
            Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
            Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
            Route::post('/bookings/check-availability', [BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
            Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
            Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
            Route::get('/bookings/check-availability', [BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
            Route::get('/bookings/{booking}/manage', [BookingController::class, 'manageRide'])->name('bookings.manage-ride');
            Route::post('/bookings/{booking}/start', [BookingController::class, 'startRide'])->name('bookings.start-ride');
            Route::post('/bookings/{booking}/complete', [BookingController::class, 'completeRide'])->name('bookings.complete-ride');
            Route::post('/bookings/{booking}/feedback', [BookingController::class, 'submitFeedback'])->name('bookings.submit-feedback');
            Route::get('/student/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
            // Stripe Payment Routes
            Route::post('/stripe/create-session/{booking}', [StripeController::class, 'session'])->name('stripe.session');
            Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
            Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
            Route::get('/bookings/{booking}/receipt', [BookingController::class, 'receipt'])->name('bookings.receipt');
        });
    });

    Route::get('/', function () {
        return view('welcome');
    });
});
