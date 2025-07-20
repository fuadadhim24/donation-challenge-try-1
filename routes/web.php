<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\RequesterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => Inertia::render('welcome'))->name('home');
Route::get('/tentang-kami', fn() => Inertia::render('about/index'))->name('about');
Route::get('/detail-donasi', fn() => Inertia::render('project/detail'))->name('detail-donation');
Route::get('/daftar-donasi', fn() => Inertia::render('project/donations'))->name('list-donation');

Route::get('/test', fn() => Inertia::render('test'))->name('test');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

Route::middleware(['auth', 'role:donor'])->group(function () {
    Route::get('/donor/dashboard', [DonorController::class, 'index'])
        ->name('donor.dashboard');
});

Route::middleware(['auth', 'role:requester'])->group(function () {
    Route::get('/requester/dashboard', [RequesterController::class, 'index'])
        ->name('requester.dashboard');
});
