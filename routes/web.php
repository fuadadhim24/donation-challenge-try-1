<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\RequesterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/tentang-kami', fn() => Inertia::render('about/index'))->name('about');
Route::get('/daftar-donasi',  [ProjectController::class, 'listProject'])->name('list-donation');
Route::get('/detail-donasi/{project}', [ProjectController::class, 'donate'])->name('detail-donation');
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

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
    Route::delete('/projects/{id}', [AdminController::class, 'destroy']);
    Route::post('/add-project', [AdminController::class, 'store'])->name('project.store');
    Route::put('/projects/{project}/status', [ProjectController::class, 'updateStatus']);
});

Route::middleware(['auth', 'role:donor'])->prefix('donor')->group(function () {
    Route::get('/dashboard', [DonorController::class, 'index'])
        ->name('donor.dashboard');
    Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');
});

Route::middleware(['auth', 'role:requester'])->prefix('requester')->group(function () {
    Route::get('/dashboard', [RequesterController::class, 'index'])
        ->name('requester.dashboard');
    Route::post('/add-project', [RequesterController::class, 'store'])->name('project.store');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
});
