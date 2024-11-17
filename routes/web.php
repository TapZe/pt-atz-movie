<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ScheduleController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifyEmailMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('welcome');
Route::get('/movie/{id}', [HomeController::class, 'movie'])->name('movie.detail');
Route::get('/cinema/{id}', [HomeController::class, 'cinema'])->name('cinema.detail');
Route::get('/schedule/{id}', [ScheduleController::class, 'schedule'])->name('schedule.detail');

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/booking/{id}/arrive', [DashboardController::class, 'arrive'])->name('booking.arrive');
});

Route::middleware(['auth', VerifyEmailMiddleware::class])->group(function () {
    // Profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/history', [ProfileController::class, 'history'])->name('profile.history');

    // Ticket buying
    Route::post('/checkout', [ScheduleController::class, 'checkout'])->name('checkout');
    Route::post('/book-seats', [ScheduleController::class, 'bookSeats'])->name('book.seats');
});

require __DIR__ . '/auth.php';
