<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // booking route
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store']);

    //Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    //Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

require __DIR__.'/auth.php';
